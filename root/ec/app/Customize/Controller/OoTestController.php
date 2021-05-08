<?php

namespace Customize\Controller;

// test6

use Eccube\Controller\AbstractController;
use Eccube\Entity\Customer;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Repository\CustomerFavoriteProductRepository;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OoTestController extends AbstractController
{

	/**
	 * @var CustomerFavoriteProductRepository
	 */
	protected $customerFavoriteProductRepository;

	/**
	 * OoTestController constructor.
	 *
	 * @param CustomerFavoriteProductRepository $customerFavoriteProductRepository
	 */
	public function __construct(
		CustomerFavoriteProductRepository $customerFavoriteProductRepository
	) {
		$this->customerFavoriteProductRepository = $customerFavoriteProductRepository;
	}

	/**
	 * ログインユーザー.
	 * お気に入り商品.
	 *
	 * @Route("/ootest6", name="ootest6")
	 * @Template("ootest.twig")
	 */
	public function ooTestFavoriteList( Request $request, Paginator $paginator ) {
		$resdponse = $this-> get_favorite_list( $request, $paginator );
		return $resdponse;
	}

	/**
	 * oo_function : get_customer_with_favorites
	 */
	private function get_favorite_list( Request $request, Paginator $paginator ) {
		$Customer = $this->getUser();
		$customer = [];
		if( isset( $Customer[ 'name01' ] ) && isset( $Customer[ 'name01' ] ) ) {
			$customer[ 'name' ] = $Customer[ 'name01' ] . ' ' . $Customer[ 'name02' ];
			$customer[ 'company_name' ] = $Customer[ 'company_name' ] ?? '';
		}
		$favorites = [];
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
					$favorites[] = $v[ 'Product' ][ 'wp_products_code' ];
				}
			}
		}
		return [
			'customer' => var_export( $customer, true ),
			'favorites' => var_export( $favorites, true )
		];
	}



	// /**
	//  * ログインユーザー.
	//  * お気に入り商品.
	//  * 完全動作版
	//  *
	//  * @Route("/ootest6", name="ootest6")
	//  * @Template("ootest.twig")
	//  */
	// public function ooTestFavoriteList( Request $request, Paginator $paginator ) {
	// 	$Customer = $this->getUser();
	// 	$customer = [];
	// 	if( isset( $Customer[ 'name01' ] ) && isset( $Customer[ 'name01' ] ) ) {
	// 		$customer[ 'name' ] = $Customer[ 'name01' ] . ' ' . $Customer[ 'name02' ];
	// 		$customer[ 'company_name' ] = $Customer[ 'company_name' ] ?? '';
	// 	}
	// 	$favorites = [];
	// 	if( $Customer ) {
	// 		$qb = $this->customerFavoriteProductRepository->getQueryBuilderByCustomer($Customer);
	// 		$event = new EventArgs(
	// 			[
	// 				'qb' => $qb,
	// 				'Customer' => $Customer,
	// 			],
	// 			$request
	// 		);
	// 		$pagination = $paginator->paginate(
	// 			$qb
	// 		);
	// 		foreach( $pagination->getItems() as  $v ) {
	// 			if( ! is_null( $v[ 'Product' ][ 'wp_products_code' ] ) ) {
	// 				$favorites[] = $v[ 'Product' ][ 'wp_products_code' ];
	// 			}
	// 		}
	// 	}
	// 	return [
	// 		'customer' => var_export( $customer, true ),
	// 		'favorites' => var_export( $favorites, true )
	// 	];
	// }






// 	// /**
// 	//  * @var ProductRepository
// 	//  */
// 	// protected $productRepository;

// 	/**
// 	 * @var CustomerFavoriteProductRepository
// 	 */
// 	protected $customerFavoriteProductRepository;

// 	// /**
// 	//  * @var BaseInfo
// 	//  */
// 	// protected $BaseInfo;

// 	// /**
// 	//  * @var CartService
// 	//  */
// 	// protected $cartService;

// 	// /**
// 	//  * @var OrderRepository
// 	//  */
// 	// protected $orderRepository;

// 	// /**
// 	//  * @var PurchaseFlow
// 	//  */
// 	// protected $purchaseFlow;

// 	/**
// 	 * MypageController constructor.
// 	 *
// 	//  * @param OrderRepository $orderRepository
// 	 * @param CustomerFavoriteProductRepository $customerFavoriteProductRepository
// 	//  * @param CartService $cartService
// 	//  * @param BaseInfoRepository $baseInfoRepository
// 	//  * @param PurchaseFlow $purchaseFlow
// 	 */
// 	public function __construct(
// 		// OrderRepository $orderRepository,
// 		CustomerFavoriteProductRepository $customerFavoriteProductRepository
// 		// ,
// 		// CartService $cartService,
// 		// BaseInfoRepository $baseInfoRepository,
// 		// PurchaseFlow $purchaseFlow
// 	) {
// 		// $this->orderRepository = $orderRepository;
// 		$this->customerFavoriteProductRepository = $customerFavoriteProductRepository;
// 		// $this->BaseInfo = $baseInfoRepository->get();
// 		// $this->cartService = $cartService;
// 		// $this->purchaseFlow = $purchaseFlow;
// 	}

// 	/**
// 	 * お気に入り商品.
// 	 *
// 	 * @Route("/ootest6", name="ootest6")
// 	 * @Template("ootest.twig")
// 	 *
// 	 * @param Product $Product
// 	 */
// 	public function ooTestFavoriteList(Request $request, Paginator $paginator)
// 	{
// 		// if (!$this->BaseInfo->isOptionFavoriteProduct()) {
// 		// 	throw new NotFoundHttpException();
// 		// }
// 		$Customer = $this->getUser();

// // dump($Customer);
// // dump($Customer[ 'name01' ]);
// // dump($Customer[ 'name02' ]);
// // dump($Customer[ 'company_name' ]);

// 		$customer = [];
// 		if( isset( $Customer[ 'name01' ] ) && isset( $Customer[ 'name01' ] ) ) {
// 			$customer[ 'name' ] = $Customer[ 'name01' ] . ' ' . $Customer[ 'name02' ];
// 			$customer[ 'company_name' ] = $Customer[ 'company_name' ] ?? '';
// 		}

// 		$favorites = [];
// 		if( $Customer ) {
// 			// paginator
// 			$qb = $this->customerFavoriteProductRepository->getQueryBuilderByCustomer($Customer);
// 			$event = new EventArgs(
// 				[
// 					'qb' => $qb,
// 					'Customer' => $Customer,
// 				],
// 				$request
// 			);
// 			$pagination = $paginator->paginate(
// 				$qb
// 			);
// 			foreach( $pagination->getItems() as  $v ) {
// 				if( ! is_null( $v[ 'Product' ][ 'wp_products_code' ] ) ) {
// 					$favorites[] = $v[ 'Product' ][ 'wp_products_code' ];
// 				}
// 			}
// 		}


// // 		$query = $qb->select("plob")
// // ->from("Eccube\\Entity\\Master\\ProductListOrderBy", "plob")
// // ->where('plob.id = :id')
// // ->setParameter('id', $this->eccubeConfig['eccube_product_order_newer'])
// // ->getQuery();

// // dump($qb);



// // dump($event);
// 		//$this->eventDispatcher->dispatch(EccubeEvents::FRONT_MYPAGE_MYPAGE_FAVORITE_SEARCH, $event);


// // dump($this->customerFavoriteProductRepository);

// 		// return [
// 		//     'pagination' => $pagination,
// 		// ];
// 		return [
// 			'customer' => var_export( $customer, true ),
// 			'favorites' => var_export( $favorites, true )
// 		];
// 		// return [
// 		// 	'test' => 'test6'
// 		// ];
// 	}

	// /**
	//  * お気に入り商品.
	//  *
	//  * @Route("/test06", name="test06")
	//  * @Template("ootest.twig")
	//  */
	// public function favorite(Request $request, Paginator $paginator)
	// {
	// 	if (!$this->BaseInfo->isOptionFavoriteProduct()) {
	// 		throw new NotFoundHttpException();
	// 	}
	// 	$Customer = $this->getUser();

	// 	// paginator
	// 	$qb = $this->customerFavoriteProductRepository->getQueryBuilderByCustomer($Customer);

	// 	$event = new EventArgs(
	// 		[
	// 			'qb' => $qb,
	// 			'Customer' => $Customer,
	// 		],
	// 		$request
	// 	);
	// 	$this->eventDispatcher->dispatch(EccubeEvents::FRONT_MYPAGE_MYPAGE_FAVORITE_SEARCH, $event);

	// 	$pagination = $paginator->paginate(
	// 		$qb,
	// 		$request->get('pageno', 1),
	// 		$this->eccubeConfig['eccube_search_pmax'],
	// 		['wrap-queries' => true]
	// 	);

	// 	return [
	// 		'pagination' => $pagination,
	// 	];
	// }

// 	/**
// 	 * お気に入り商品.
// 	 *
// 	 * @Route("/ootest6", name="ootest6")
// 	 * @Template("ootest.twig")
// 	 *
// 	 * @param Product $Product
// 	 */
// 	public function ooTestFavoriteList(): array
// 	{
// 		$User = $this->requestContext->getCurrentUser();

// 		if($User && $User instanceof Customer) {
// 			$res = $this->customerFavoriteProductRepository->findBy([
// 				"Customer" => $User
// 			]);
// 		}
// dump($res);
// 		// return [
// 		// 	'test' => var_dump( $res, true )
// 		// ];
// 		return [
// 			'test' => 'test6'
// 		];
// 	}



// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Eccube\Controller\AbstractController;
// use Eccube\Entity\Product;
// use Eccube\Form\Type\AddCartType;
// use Eccube\Application;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
	// /**
	//  * @Route("/ootest5/{id}", name="ootest5", methods={"GET"})
	//  * @Template("ootest.twig")
	//  */
	// public function ooTestCartFormToken() {
	// 	return [
	// 		'test' => self::get_cart_form_token()
	// 	];
	// }

	// /**
	//  * oo_function : get_cart_form_token
	//  *
	//  * @param Request $request
	//  * @param Product $Product
	//  */
	// private static function get_cart_form_token( Request $request, Product $Product ) {
	// 	$app = \Eccube\Application::getInstance();
	// 	$builder = $app->getParentContainer()->formFactory->createNamedBuilder(
	// 		'',
	// 		AddCartType::class,
	// 		null,
	// 		[
	// 			'product' => $Product,
	// 			'id_add_product_id' => false,
	// 		]
	// 	);
	// 	$response = '';
	// 	return var_export( $response, true );
	// }

	// /**
	//  * oo_function : get_product 商品取得
	//  */
	// private static function get_product( $id ) {
	// 	$app = \Eccube\Application::getInstance();
	// 	$productRepository = $app->getParentContainer()->get( 'Eccube\Repository\ProductRepository' );
	// 	return $productRepository->find( $id );
	// }

	// /**
	//  * @Route("/ootest5/{id}", name="ootest5", methods={"GET"})
	//  * @Template("ootest.twig")
	//  */
 	// public function ooTestCartFormToken() {
	// 	return [
	// 		'test' => self::get_cart_form_token()
	// 	];
	// }

	// /**
	//  * oo_function : get_cart_form_token
	//  *
	//  * @param Request $request
	//  * @param Product $Product
	//  */
	// private static function get_cart_form_token( Request $request, Product $Product ) {
	// 	$app = \Eccube\Application::getInstance();
	// 	$builder = $app->getParentContainer()->formFactory->createNamedBuilder(
	// 		'',
	// 		AddCartType::class,
	// 		null,
	// 		[
	// 			'product' => $Product,
	// 			'id_add_product_id' => false,
	// 		]
	// 	);
	// 	$response = '';
	// 	return var_export( $response, true );
	// }


// // test4

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Eccube\Controller\AbstractController;
// use Eccube\Entity\Product;
// use Eccube\Form\Type\AddCartType;
// use Eccube\Application;

// 	/**
// 	 * @Route("/ootest4", name="ootest4")
// 	 * @Template("ootest.twig")
// 	 */
//  	public function ooTestAllCarts() {
// 		return [
// 			'Carts' => self::get_carts()
// 		];
// 	}

// 	/**
// 	 * oo_function : get_carts
// 	 */
// 	private static function get_carts() {
// 		$app = \Eccube\Application::getInstance();
// 		$CartService = $app->getParentContainer()->get( 'Eccube\Service\CartService' );
// 		$Carts = $CartService->getCarts();
// 		$done = [];
// 		$done[ 'carts' ]                = [];
// 		$done[ 'carts_total_price' ]    = 0;
// 		$done[ 'carts_total_quantity' ] = 0;
// 		foreach( $Carts as $Cart ) {
// 			$done[ 'carts_total_price' ]    += $Cart->getTotalPrice();
// 			$done[ 'carts_total_quantity' ] += $Cart->getQuantity();
// 			foreach( $Cart->getCartItems() as  $k => $v ) {
// 				$done[ 'carts' ][ $Cart->getCartKey() ][ $k ][ 'name' ] =             $v[ 'ProductClass' ][ 'Product' ][ 'name' ];
// 				$done[ 'carts' ][ $Cart->getCartKey() ][ $k ][ 'wp_products_code' ] = $v[ 'ProductClass' ][ 'Product' ][ 'wp_products_code' ] ?? 'nocode';
// 				$done[ 'carts' ][ $Cart->getCartKey() ][ $k ][ 'price02_inc_tax' ] =  $v[ 'ProductClass' ][ 'price02_inc_tax' ];
// 				$done[ 'carts' ][ $Cart->getCartKey() ][ $k ][ 'quantity' ] =         $v[ 'quantity' ];
// 			}
// 		}
// 		// return [
// 		// 	'Carts' => var_export( $done, true )
// 		// ];
// 		return var_export( $done, true );
// 	}




// // test3
// // use Eccube\Entity\BaseInfo;
// // use Eccube\Entity\ProductClass;
// // use Eccube\Event\EccubeEvents;
// // use Eccube\Event\EventArgs;
// // use Eccube\Repository\BaseInfoRepository;
// // use Eccube\Repository\ProductClassRepository;
// use Eccube\Service\CartService;
// use Eccube\Service\PurchaseFlow\PurchaseContext;
// use Eccube\Service\PurchaseFlow\PurchaseFlow;
// use Eccube\Service\PurchaseFlow\PurchaseFlowResult;
// // use Eccube\Service\OrderHelper;
// use Eccube\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// // use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Component\Routing\Annotation\Route;

// 	/**
// 	 * @var CartService
// 	 */
// 	protected $cartService;

// 	/**
// 	 * @var PurchaseFlow
// 	 */
// 	protected $purchaseFlow;

// 	/**
// 	 * CartController constructor.
// 	 *
// 	 * @param CartService $cartService
// 	 * @param PurchaseFlow $cartPurchaseFlow
// 	 */
// 	public function __construct(
// 		CartService $cartService,
// 		PurchaseFlow $cartPurchaseFlow
// 	) {
// 		$this->cartService = $cartService;
// 		$this->purchaseFlow = $cartPurchaseFlow;
// 	}

// 	/**
// 	 * wpからのカート情報.
// 	 *
// 	 * @Route("/ootest3", name="ootest3")
// 	 * @Template("ootest.twig")
// 	 */
// 	public function ooTestAllinfo( Request $request ) {

// 		$Carts = $this->cartService->getCarts();
// 		$this->execPurchaseFlow( $Carts );
// 		$totalPrice = 0;
// 		$totalQuantity = 0;
// 		foreach( $Carts as $Cart ) {
// 			$totalPrice    += $Cart->getTotalPrice();
// 			$totalQuantity += $Cart->getQuantity();
// 		}
// 		$Carts = $this->cartService->getCarts( true );
// 		$ResCustomer = [];
// 		$ResCarts = [];
// 		foreach( $Carts as $Cart ) {
// // // dump( $Carts );
// // // dump( $Cart->getCartKey() );
// // dump( $Cart->getId() );
// // dump( $Cart->getCustomer() );
// // dump( $Cart->getCustomer()[ 'name01' ] );
// // // dump( $Cart->getCartItems()[0] );
// // // dump( $Cart->getCartItems()[0][ 'price']);
// // // dump( $Cart->getCartItems()[0][ 'quantity'] );
// // dump( $Cart->getCartItems()[0][ 'ProductClass'] );
// // // dump( $Cart->getCartItems()[0][ 'ProductClass'][ 'code' ] );
// // dump( $Cart->getCartItems()[0][ 'ProductClass'][ 'Product'] );
// // // dump( $Cart->getCartItems()[0][ 'ProductClass'][ 'Product'][ 'name' ] );
// 			$tempCustomer = $Cart->getCustomer();
// 			if( $tempCustomer ) {
// 				$ResCustomer[ 'name01' ] = $tempCustomer[ 'name01' ];
// 				$ResCustomer[ 'name02' ] = $tempCustomer[ 'name02' ];
// 				$ResCustomer[ 'company_name' ] = $tempCustomer[ 'company_name' ];
// 			}
// 			foreach( $Cart->getCartItems() as  $k => $v ) {
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'price' ] =            $v[ 'price' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'quantity' ] =         $v[ 'quantity' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'class_id' ] =         $v[ 'ProductClass' ][ 'id' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'code' ] =             $v[ 'ProductClass' ][ 'code' ] ?? 'nocode';
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'price02' ] =          $v[ 'ProductClass' ][ 'price02' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'price02_inc_tax' ] =  $v[ 'ProductClass' ][ 'price02_inc_tax' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'id' ] =               $v[ 'ProductClass' ][ 'Product' ][ 'id' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'name' ] =             $v[ 'ProductClass' ][ 'Product' ][ 'name' ];
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'input_process' ] =    $v[ 'ProductClass' ][ 'Product' ][ 'input_process' ] ?? 'noprocess';
// 				$ResCarts[ $Cart->getCartKey() ][ $k ][ 'wp_products_code' ] = $v[ 'ProductClass' ][ 'Product' ][ 'wp_products_code' ] ?? 'nocode';
// 			}
// 		}
// 		return [
// 			'totalPrice' => $totalPrice,
// 			'totalQuantity' => $totalQuantity,
// 			'Customer' => var_export( $ResCustomer, true ),
// 			'Carts' => var_export( $ResCarts, true )
// 		];
// 	}

	// /**
	//  * @param $Carts
	//  *
	//  * @return \Symfony\Component\HttpFoundation\RedirectResponse
	//  */
	// protected function execPurchaseFlow( $Carts ) {
	// 	/** @var PurchaseFlowResult[] $flowResults */
	// 	$flowResults = array_map( function ( $Cart ) {
	// 		$purchaseContext = new PurchaseContext( $Cart, $this->getUser() );
	// 		return $this->purchaseFlow->validate( $Cart, $purchaseContext );
	// 	}, $Carts );
	// 	$hasError = false;
	// 	foreach ( $flowResults as $result ) {
	// 		if ( $result->hasError() ) {
	// 			$hasError = true;
	// 			foreach ( $result->getErrors() as $error ) {
	// 				$this->addRequestError( $error->getMessage() );
	// 			}
	// 		}
	// 	}
	// 	if ( $hasError ) {
	// 		$this->cartService->clear();
	// 		return $this->redirectToRoute( 'cart' );
	// 	}
	// 	$this->cartService->save();
	// 	foreach ( $flowResults as $index => $result ) {
	// 		foreach ( $result->getWarning() as $warning ) {
	// 			if ( $Carts[ $index ]->getItems()->count() > 0 ) {
	// 				$cart_key = $Carts[ $index ]->getCartKey();
	// 				$this->addRequestError( $warning->getMessage(), "front.cart.${cart_key}" );
	// 			} else {
	// 				$this->addRequestError( $warning->getMessage() );
	// 			}
	// 		}
	// 	}
	// }

// // test2
// use Eccube\Entity\Master\ProductStatus;
// use Eccube\Entity\Product;
// use Eccube\Event\EccubeEvents;
// use Eccube\Event\EventArgs;
// use Eccube\Form\Type\AddCartType;
// use Eccube\Repository\CustomerFavoriteProductRepository;
// use Eccube\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Symfony\Component\Routing\Annotation\Route;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

	// /**
	//  * @var CustomerFavoriteProductRepository
	//  */
	// protected $customerFavoriteProductRepository;

	// /**
	//  * OoTestController constructor.
	//  *
	//  * @param CustomerFavoriteProductRepository $customerFavoriteProductRepository
	//  */
	// public function __construct(
	// 	CustomerFavoriteProductRepository $customerFavoriteProductRepository
	// ) {
	// 	$this->customerFavoriteProductRepository = $customerFavoriteProductRepository;
	// }

	// /**
	//  * お気に入りチェック
	//  *
	//  * @Route("/ootest2/{id}", name="ootest", methods={"GET"})
	//  * @Template("ootest.twig")
	//  *
	//  * @param Request $request
	//  * @param Product $Product
	//  *
	//  * @return array
	//  */
	// public function ooTestApiIsFavorite(Request $request, Product $Product)
	// {
	// 	if (!$this->checkVisibility($Product)) {
	// 		throw new NotFoundHttpException();
	// 	}

	// 	$builder = $this->formFactory->createNamedBuilder(
	// 		'',
	// 		AddCartType::class,
	// 		null,
	// 		[
	// 			'product' => $Product,
	// 			'id_add_product_id' => false,
	// 		]
	// 	);

	// 	$event = new EventArgs(
	// 		[
	// 			'builder' => $builder,
	// 			'Product' => $Product,
	// 		],
	// 		$request
	// 	);
	// 	$this->eventDispatcher->dispatch(EccubeEvents::FRONT_PRODUCT_DETAIL_INITIALIZE, $event);

	// 	$is_favorite = false;
	// 	if( $this->isGranted( 'ROLE_USER' ) ) {
	// 		$Customer = $this->getUser();
	// 		$is_favorite = $this->customerFavoriteProductRepository->isFavorite( $Customer, $Product );
	// 	}

	// 	return [
	// 		'Product' => $Product,
	// 		'is_favorite' => $is_favorite
	// 	];
	// }

	// /**
	//  * 商品閲覧可能判定
	//  *
	//  * @param Product $Product
	//  *
	//  * @return boolean 閲覧可能な場合はtrue
	//  */
	// protected function checkVisibility(Product $Product) {
	// 	$is_admin = $this->session->has('_security_admin');

	// 	// 管理ユーザ：常時閲覧可能.
	// 	if( ! $is_admin ) {
	// 		// 在庫なし非表示オプション：default 参照
	// 		// 非公開：非表示
	// 		if( $Product->getStatus()->getId() !== ProductStatus::DISPLAY_SHOW ) {
	// 			return false;
	// 		}
	// 	}

	// 	return true;
	// }

	// test1
	// use Eccube\Entity\Product;
	// use Eccube\Form\Type\AddCartType;
	// use Eccube\Controller\AbstractController;
	// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
	// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

// 	/**
// 	 * 商品ごとのtoken取得
// 	 *
// 	 * @Route("/ootest/{id}", name="ootest", methods={"GET"})
// 	 * @Template("ootest.twig")
// 	 * @param Product $Product
// 	 * @return array
// 	 */
// 	public function ooTestMethod(Product $Product)
// 	{

// 		$builder = $this->formFactory->createNamedBuilder(
// 			'',
// 			AddCartType::class,
// 			null,
// 			[ 'product' => $Product ]
// 		);
// 		$temp = $builder->getForm()->createView();

// // dump($Product);
// // dump($temp[ '_token']->vars[ 'value' ]);

// 		return [
// 			'Product' => $Product,
// 			'test'    => $temp[ '_token']->vars[ 'value' ],
// 		];
// 	}
}
