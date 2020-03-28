<?php


namespace FrisbyModule\Frisby;


class Form
{
	public $object;

	public function __construct($formID, $method = 'GET')
	{
		$this->newForm($formID, $method, '');
	}

	/**
	 * @param null $id
	 * @param string $method
	 * @param string $action
	 * @param array $additional
	 */
	public function newForm($id, $method = 'GET', $action = "", $additional = [])
	{
		$this->object = (object)[
			"form" => [
				"id" => $id,
				"method" => $method,
				"action" => $action,
				"autocomplete" => "off",
				"enctype" => "application/x-www-form-urlencoded",
				"target" => "_self",
				"novalidate" => false
			],
			"elements" => []
		];
		$this->object->form = (object)array_merge((array)$this->object->form, $additional);
		return (object)$this->object;
	}

	/**
	 * @param $label
	 * @param $element
	 */
	public function addElement($label, FormInterface $element)
	{
		$this->object->elements[] = (object)[
			"label" => (object) ["text" => $label, "for" => $element->object->id],
			"element" => $element
		];
	}

	/**
	 * @param $form
	 */
	public static function __render($form)
	{
		$html = "<form ";
		foreach ((array) $form->object->form as $attr => $item) {
			$html .= ($item)?$attr."='".$item."' ":null;
		}
		$html .= ">".PHP_EOL;
		foreach($form->object->elements as $element){
			$html .= "<label for='{$element->label->for}'>{$element->label->text}</label>".PHP_EOL;
			$html .= "<{$element->element->object->tag} ".PHP_EOL;
			foreach($element->element->object as $attr => $value){
				$html .= ($attr == "tag" || $attr == "options") ? null : " {$attr}='{$value}'";
				if($attr == "options"){
					$html .='>'.PHP_EOL;
					foreach($value as $option){
						$html .= "<option value='{$option['value']}'";
						$html .= (isset($option['disabled']) && @$option['disabled']) ? " disabled " : null;
						$html .= (isset($option['selected']) && @$option['selected']) ? " selected " : null;
						$html .= ">{$option['text']}</option>".PHP_EOL;
					}
				}
			}
			$html .= ($element->element->object->tag == "input") ?"/>":($element->element->object->tag == "textarea" ? ">": null);

			$html.= ($element->element->object->tag == "input") ? null : "</{$element->element->object->tag}>";
		}
		echo $html;
	}

	public function __destruct()
	{
		//print_r($this->object);
	}

}