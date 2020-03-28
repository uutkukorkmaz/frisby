<?php

$app->route->add('/', 'IndexController');

$app->route->add('/test', function () {
	// Your quick controller...
	echo "quick controller";
});

$app->route->add('/form-module', function () {
	$exampleForm = new FrisbyModule\Frisby\Form('testForm');
	$exampleForm->addElement('test', new \FrisbyModule\Frisby\Form\Input('test'));
	$exampleForm->addElement('test select', new \FrisbyModule\Frisby\Form\Select('testSelect', [
			["value" => "test", "text" => "Test Option 1","disabled"=>true,"selected"=>true],
			["value" => "test2", "text" => "Test Option 2","disabled"=>false,"selected"=>false],
		]));

	$exampleForm->__render($exampleForm);
});