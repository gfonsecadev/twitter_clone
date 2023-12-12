<?php
namespace App\Controllers;
use MF\Controller\Action;
use MF\Model\Container;
use App\Model\Usuarios;
class TimelineControllers extends Action{
	public function carregar($class="TimelineControllers"){

		session_start();
		if (isset($_SESSION['email']) && isset($_SESSION['senha'])) {

			$usuario_logado=Container::getModel('Usuarios');
			$usuario_logado->__set("email",$_SESSION['email']);
			$usuario_logado->__set("senha",$_SESSION['senha']);
			$this->data->dados_usuario=$usuario_logado->carregar_dados_usuario();
			$usuario_logado->__set('id',$this->data->dados_usuario['id']);
			$this->data->dados_tweets=$usuario_logado->carregar_tweets_usuario();
			if ($class=="TimelineControllers") {
				$this->render('timeline');
			}

			

		}else{
			header('Location:/?erro=naoLogado');
		}
		
	}

	public function salvar_tweet(){
		session_start();
		$id_usuario=$_SESSION['id'];
		Usuarios::salvar_tweet($id_usuario,$_POST['tweet']);
		header("Location:/timeline");
	}

	public function sair(){
		session_start();
		session_destroy();
		header("Location:/");
	}

}



?>