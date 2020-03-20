<?php


namespace FrisbyModule\Frisby;


/**
 * Class Loader
 * @package FrisbyModule\Frisby
 */
class Loader
{
	private $classMap;
	public $loadClasses=[];


	const IMAGE = '/assets/img/';
	const STYLE = '/assets/css/';
	const FONT = '/assets/fonts/';
	const SCRIPT = '/assets/js/';
	/**
	 * Loader constructor.
	 * @param null $file
	 * @param null $type
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
			$classDir = realpath('.').$this->classMap['psr-4'][$namespace].'/';
			$this->loadClasses[end($psr4_class)] = $classDir.$psr4_class[1].'/'.$psr4_class[2].'.php';
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