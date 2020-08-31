<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;

/**
 * Frisby Framework
 * Loader Class
 *
 * The loader class based on PSR-4 standarts of PHP-FIG. Also this class generates URLs to asset files for HTML
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Loader
{
	private $classMap;
	public $loadClasses=[];


	const IMAGE = 'assets/img/';
	const STYLE = 'assets/css/';
	const FONT = 'assets/fonts/';
	const SCRIPT = 'assets/js/';
	/**
	 * Loader constructor.
	 */
	public function __construct(){
		$this->getClassMap();
	}

	/**
	 * @param $classname
	 * @return bool|mixed
	 */
	public function classLoader($classname){
		$psr4_class = explode('\\',$classname);
		$namespace = $psr4_class[0].'\\';
		if(in_array($namespace,array_keys($this->classMap['psr-4']))){
			$classDir = realpath('.').$this->classMap['psr-4'][$namespace];
			$path = $classDir;
			foreach ($psr4_class as $class){
				if($class != $psr4_class[0])
					$path.='/'.$class;
			}
			$this->loadClasses[end($psr4_class)] = $path.'.php';
			return $this->loadClasses[end($psr4_class)];
		}else{
			//TODO: ERROR HANDLER
			return false;
		}
	}

	/**
	 * Generates an array from /autoload.json for loading class with PSR-4 standards.
	 */
	private function getClassMap(){
		$classMapFile = realpath('.').'/autoload.json';
		if(file_exists($classMapFile)) {
			$this->classMap = json_decode(file_get_contents($classMapFile),true);
		}
	}

	/**
	 * Prepares path string for View node
	 * @param $view
	 * @return bool|string
	 */
	public function view($view){
		$path = realpath('.').$this->classMap['psr-4']['FrisbyApp\\'].'/View/'.$view.'.php';
		if(file_exists($path)){
			return $path;
		}else{
			return false;
		}
	}

	/**
	 * Prepates path string for locale file
	 * @param $lang
	 * @return string
	 */
	public function lang($lang){
		$path = realpath('.').'/lib/languages/'.$lang.'.lang.php';
		if(file_exists($path)) {
			return $path;
		}else{
			return false;
		}
	}
}