<?php
/*--------------------------------------------------------------

	ProductTrait

	@version
		18.1.1

	@memo

		ssh [loginid]@[sshhost.sakura.ne.jp]
		cd www/[official01]/ec
		bin/console cache:clear --no-warmup
		bin/console doctrine:schema:update --dump-sql
		bin/console doctrine:schema:update --dump-sql --force

---------------------------------------------------------------*/

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Eccube\EntityExtension("Eccube\Entity\Product")
 */

trait ProductTrait
{

	/**
	 * @ORM\Column(name="input_process", type="string", length=255, nullable=true)
	 * @Eccube\FormAppend(
	 *     auto_render=true,
	 *     type="\Symfony\Component\Form\Extension\Core\Type\TextType",
	 *     options={
	 *          "required": false,
	 *          "label": "入力経緯"
	 *     })
	 */
	public $input_process;
	/**
	 * Set InputProcess.
	 *
	 * @param string|null InputProcess
	 *
	 * @return Product
	 */
	public function setInputProcess($InputProcess = null)
	{
		$this->input_process = $InputProcess;

		return $this;
	}
	/**
	 * Get InputProcess.
	 *
	 * @return string|null
	 */
	public function getInputProcess()
	{
		return $this->input_process;
	}

	/**
	 * @ORM\Column(name="wp_products_code", type="string", length=255, nullable=true)
	 * @Eccube\FormAppend(
	 *     auto_render=true,
	 *     type="\Symfony\Component\Form\Extension\Core\Type\TextType",
	 *     options={
	 *          "required": false,
	 *          "label": "WP商品コード"
	 *     })
	 */
	public $wp_products_code;
	/**
	 * Set wpProductsCode.
	 *
	 * @param string|null wpProductsCode
	 *
	 * @return Product
	 */
	public function setwpProductsCode($wpProductsCode = null)
	{
		$this->wp_products_code = $wpProductsCode;

		return $this;
	}
	/**
	 * Get wpProductsCode.
	 *
	 * @return string|null
	 */
	public function getwpProductsCode()
	{
		return $this->wp_products_code;
	}
}