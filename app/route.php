<?php
namespace App;


use MF\Route\Bootstrap;
class Route extends Bootstrap{
	

	protected function initRoutes(){
		$routes['home']=array(
			'route'=>"/",
			'controller'=>'indexControllers',
			'acao'=>'index'
		);
		$routes['inscreverse']=array(
			'route'=>"/inscreverse",
			'controller'=>'indexControllers',
			'acao'=>'inscreverse'
		);

		$routes['cadastro']=array(
			'route'=>"/cadastrar",
			'controller'=>'authControllers',
			'acao'=>'cadastrar'
		);

		$routes['autenticacao']=array(
			'route'=>"/autenticar",
			'controller'=>'authControllers',
			'acao'=>'autenticar'
		);

		$routes['timeline']=array(
			'route'=>"/timeline",
			'controller'=>'timelineControllers',
			'acao'=>'carregar'
		);

		$routes['salvar_tweet']=array(
			'route'=>"/save",
			'controller'=>'timelineControllers',
			'acao'=>'salvar_tweet'
		);


		$routes['sair']=array(
			'route'=>"/sair",
			'controller'=>'timelineControllers',
			'acao'=>'sair'
		);

		$routes['seguir']=array(
			'route'=>"/seguir",
			'controller'=>'seguirControllers',
			'acao'=>'seguir'
		);

		

		
		$this->setRoutes($routes);
	}


	

	
}



?>