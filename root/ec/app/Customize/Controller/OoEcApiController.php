<?php
/*--------------------------------------------------------------

	OoEcApiController

	@version
		18.1.1

	@memo

---------------------------------------------------------------*/

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Component\Pager\Paginator;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Product;
use Eccube\Form\Type\AddCartType;
use Eccube\Application;
use Eccube\Repository\CustomerFavoriteProductRepository;
use Eccube\Entity\Customer;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Customize\Util\GetWpdb;
class OoEcApiController extends AbstractController
{

	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var CustomerFavoriteProductRepository
	 */
	protected $customerFavoriteProductRepository;

	/**
	 * OoEcApiController constructor.
	 *
	 * @param Application $application
	 * favorit
	 * @param CustomerFavoriteProductRepository $customerFavoriteProductRepository
	 * carts
	 * @param CartService $cartService
	 * @param PurchaseFlow $cartPurchaseFlow
	 */
	public function __construct(
		CustomerFavoriteProductRepository $customerFavoriteProductRepository,
		Application $application
	) {
		$this->customerFavoriteProductRepository = $customerFavoriteProductRepository;
		$this->application = $application;
	}

	/**
	 * wpからeccubeの全情報取得.
	 *
	 * @Route("/oo_ec_all_info", name="api_all_info", methods={"POST"})
	 */
	public function apiAllinfo( Request $request, Paginator $paginator ) {
		if( ! $request->isXmlHttpRequest() ) {
			throw new BadRequestHttpException();
		}
		$resdponse = $this-> get_favorite_list( $request, $paginator );
		$done = [];
		$done[ 'api' ]                 = 'all_info';
		$done[ 'token' ]               = $this->get_token();
		$done[ 'logged_in' ]           = $this->is_granted();
		$done[ 'carts' ]               = $this->get_carts();
		$done[ 'customer' ]            = $this-> get_favorite_list( $request, $paginator )[ 'customer' ];
		$done[ 'favorites' ]           = $this-> get_favorite_list( $request, $paginator )[ 'favorites' ];
		return $this->json( $done );
	}

	/**
	 * wpからeccubeのカート情報取得.
	 *
	 * @Route("/oo_ec_carts", name="api_carts", methods={"POST"})
	 */
	public function apiCarts( Request $request ) {
		if( ! $request->isXmlHttpRequest() ) {
			throw new BadRequestHttpException();
		}
		$done = [];
		$done[ 'api' ]                 = 'carts';
		$done[ 'carts' ]               = $this->get_carts();
		return $this->json( $done );
	}

	/**
	 * wpからのカートフォームtoken取得
	 *
	 * @Route("/oo_ec_cart_token/{id}", name="api_cart_token", methods={"GET"})
	 * @param Product $Product
	 * @return array
	 */
	public function apiCartToken( Request $request, Product $Product ) {
		if( ! $request->isXmlHttpRequest() ) {
			throw new BadRequestHttpException();
		}
		$builder = $this->formFactory->createNamedBuilder(
			'',
			AddCartType::class,
			null,
			[ 'product' => $Product ]
		);
		$form = $builder->getForm()->createView();
		$done = [];
		$done[ 'api' ]                 = 'cart_token';
		$done[ 'cart_toke' ]           = $form['_token']->vars[ 'value' ];
		return $this->json( $done );
	}

	/**
	 * oo_function : get_token
	 */
	private function get_token() {
		$app = $this->application::getInstance();
		$tokenProvider = $app->getParentContainer()->get( 'security.csrf.token_manager' );
		$token = $tokenProvider->getToken( '_token' )->getValue();
		return $token;
	}

	/**
	 * oo_function : get_token_auth
	 */
	private function get_token_auth() {
		$app = $this->application::getInstance();
		$tokenProvider = $app->getParentContainer()->get('security.csrf.token_manager');
		$token = $tokenProvider->getToken('authenticate')->getValue();
		return $token;
	}

	/**
	 * oo_function : is_granted
	 */
	private function is_granted() {
		$app = $this->application::getInstance();
		$response = $app->getParentContainer()->get( 'security.authorization_checker' )->isGranted( 'ROLE_USER' );
		return $response;
	}

	/**
	 * oo_function : get_carts
	 */
	private function get_carts() {
		$app = $this->application::getInstance();
		$CartService = $app->getParentContainer()->get( 'Eccube\Service\CartService' );
		$Carts = $CartService->getCarts();
		$response = [];
		$response[ 'items' ]                = [];
		$response[ 'total_price' ]    = 0;
		$response[ 'total_quantity' ] = 0;
		foreach( $Carts as $Cart ) {
			$response[ 'total_price' ]    += $Cart->getTotalPrice();
			$response[ 'total_quantity' ] += $Cart->getQuantity();
			foreach( $Cart->getCartItems() as  $v ) {
				$key = $v[ 'ProductClass' ][ 'Product' ][ 'wp_products_code' ] ?? false;
				if( $key ) {
					$response[ 'items' ][ $key ][ 'name' ]     = $v[ 'ProductClass' ][ 'Product' ][ 'name' ];
					$response[ 'items' ][ $key ][ 'class01' ]  = ''; // 未実装 2021-05-08
					$response[ 'items' ][ $key ][ 'class02' ]  = ''; // 未実装 2021-05-08
					$temp_pic = GetWpdb::productsPicMain( $v[ 'ProductClass' ][ 'Product' ][ 'wp_products_code' ] );
					$response[ 'items' ][ $key ][ 'pic' ]      = $temp_pic;
					$response[ 'items' ][ $key ][ 'price' ]    = $v[ 'ProductClass' ][ 'price02_inc_tax' ];
					$response[ 'items' ][ $key ][ 'quantity' ] = $v[ 'quantity' ];
				}
			}
		}
		return $response;
	}

	/**
	 * oo_function : get_customer_with_favorites
	 */
	private function get_favorite_list( Request $request, Paginator $paginator ) {
		$Customer = $this->getUser();
		$response = [];
		$response[ 'customer' ]  = [];
		$response[ 'favorites' ] = [];
		if( isset( $Customer[ 'name01' ] ) && isset( $Customer[ 'name01' ] ) ) {
			$response[ 'customer' ][ 'name' ]         = $Customer[ 'name01' ] . ' ' . $Customer[ 'name02' ];
			$response[ 'customer' ][ 'company' ]      = $Customer[ 'company_name' ] ?? '';
		}
		if( $Customer ) {
			$qb = $this->customerFavoriteProductRepository->getQueryBuilderByCustomer($Customer);
			$event = new EventArgs(
				[
					'qb' => $qb,
					'Customer' => $Customer,
				],
				$request
			);
			$pagination = $paginator->paginate(
				$qb
			);
			foreach( $pagination->getItems() as  $v ) {
				if( ! is_null( $v[ 'Product' ][ 'wp_products_code' ] ) ) {
					$response[ 'favorites' ][] = $v[ 'Product' ][ 'wp_products_code' ];
				}
			}
		}
		return $response;
	}
}
