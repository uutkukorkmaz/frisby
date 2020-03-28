<?php


namespace FrisbyModule\Frisby\Form;


use FrisbyModule\Frisby\FormInterface;

/**
 * Class Select
 * @package FrisbyModule\Frisby\Form
 */
class Select implements FormInterface
{

	public $object;

	function __construct($name,$options=[],$id=null,$attr=[])
	{
		$id = is_null($id) ? 'select_'.substr(md5(rand(10,99)),0,7) : $id;
		$object = [
			"tag" => "select",
			"name" => $name,
			"id" => $id,
			"options" => $options
		];
		$this->object = (object) array_merge($object,$attr);
	}
}