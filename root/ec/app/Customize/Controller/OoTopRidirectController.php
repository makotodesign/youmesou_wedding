<?php
/*--------------------------------------------------------------

	OoTopRidirectController

	@version
		18.1.1

	@memo

---------------------------------------------------------------*/

namespace Customize\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Controller\AbstractController;

class OoTopRidirectController extends AbstractController
{
	/**
	 * @Route("/default", name="homepage")
	 *
	 */
	public function index()
	{
		return $this->redirect( PUBLICDIR . '/' );
	}
}
