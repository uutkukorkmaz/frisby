<?php


namespace Frisby\Framework;


/**
 * Interface MigrationInterface
 * @package Frisby\Framework
 */
interface MigrationInterface
{

	public function up();

	public function down();

}