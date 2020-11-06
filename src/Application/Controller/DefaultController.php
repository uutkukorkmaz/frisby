<?php


namespace Frisby\Application\Controller;


use Frisby\Framework\Core;
use Frisby\Service\Schema;

/**
 * Class DefaultController
 * @package Frisby\Application\Controller
 */
class DefaultController extends \Frisby\Framework\Controller
{

	/**
	 * @inheritDoc
	 */
	function render(...$params)
	{
		// TODO: Implement render() method.
		echo "this is the default controller";
	}

	function SchemaTest()
	{
		$builder = Schema::create('testTable', function (Schema\Builder $table) {
			$table = $table->int('id', 11, true)
				->varchar('name')
				->text('description')
				->setPrimaryKey('id')
				->create();

		});
	}
}