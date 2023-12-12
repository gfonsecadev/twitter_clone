<?php
namespace App\Controllers;

//use MF\Controller\Action;
use MF\Model\Container;
use MF\Controller\Action;
class AuthControllers extends Action{

	public function cadastrar(){
		$this->verificarCampos();
		$usuario=Container::getModel('Usuarios');
		$usuario->__set("nome",$_POST['nome']);
		$usuario->__set("email",$_POST['email']);
		$usuario->__set("senha",md5($_POST['senha']));
		if ($usuario->cadastrar()) {
			$this->render('cadastro');
		}
		

	}

	public function autenticar(){
		
		$usuario=Container::getModel('Usuarios');
		$usuario->__set("email",$_POST['email']);
		$usuario->__set("senha",md5($_POST['senha']));
		
		if ($usuario->verificar_autenticidade()!="") {
			session_start();
			$id=$usuario->verificar_autenticidade();
			$_SESSION['id']=$id['id'];
			$_SESSION['email']=$usuario->__get('email');
			$_SESSION['senha']=$usuario->__get('senha');
			header("Location:/timeline");
		}else {
			header("Location:/?erro=naoCadastrado");
		}
		

	}


	public function verificarCampos(){
		$nome=$_POST['nome']=!"" ? $nome=$_POST['nome']: $nome="";
		$email=$_POST['email']=!"" ? $nome=$_POST['email']: $emal="";
		$senha=$_POST['senha']=!"" ? $nome=$_POST['senha']: $senha="";
		
		if (empty($nome)||empty($email)||empty($senha)) {
			header("Location:/inscreverse?erro=camposVazios");
		}
	}

}

?>