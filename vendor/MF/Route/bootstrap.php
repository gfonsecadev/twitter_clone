<?php
namespace MF\Route;
	abstract class Bootstrap{


	private $routes;

	abstract protected function initRoutes();

	public function __construct(){
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	public function getRoutes(){
		return $this->routes;
	}

	public function setRoutes($route){
		$this->routes=$route;
	}

	public function getUrl(){
		return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	}

	protected function run($url){

		foreach ($this->getRoutes() as $routers => $route) {
			if($route['route']==$url){
				$class="App\\Controllers\\".ucfirst($route['controller']);
				$controller=new $class;
				$acao=$route['acao'];
				$controller->$acao();


				
			}
		}
	}


	}


?>