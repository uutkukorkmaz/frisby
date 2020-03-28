<?php


namespace FrisbyModule\Frisby\Form;


use FrisbyModule\Frisby\FormInterface;

/**
 * Class FormInput
 * @package FrisbyModule\Frisby\Form
 */
class Input implements FormInterface
{
	public $object;
	/**
	 * FormInput constructor.
	 * @param $name
	 * @param string $type
	 * @param null $id
	 * @param array $attr
	 */
	function __construct($name, $type = "text", $id = null, $attr = [])
	{
		$id = is_null($id) ? 'input_'.substr(md5(rand(10,99)),0,7) : $id;
		$object = [
			"tag" => "input",
			"name" => $name,
			"type" => $type,
			"id" => $id
		];
		$this->object = (object) array_merge($object, $attr);
	}
}