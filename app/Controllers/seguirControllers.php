<?php
namespace App\Controllers;
use App\Model\Usuarios;
use App\Controllers\TimelineControllers;

Class SeguirControllers extends TimelineControllers{
	


	public function seguir(){
		//funcao herdada de timelineController para carregar dados do usuario.
		$this->carregar("SeguirControllers");
		session_start();
		$id_usuario=$_SESSION['id'];

		//condicional para pesquisa.		
		if (isset($_POST['procurar'])) {
			
			$this->data->dados_pesquisa=Usuarios::procurar_usuario($_POST['procurar'],$id_usuario);
			
		}
		//condicional para seguir ou deixar de seguir.
		if (isset($_GET['acao']) && isset($_GET['id_seguir'])) {
			if ($_GET['acao']=='seguir') {
				Usuarios::seguir_ou_deixarDeSeguir("seguir",$id_usuario,$_GET['id_seguir']);
				header("Location:\seguir");
			}elseif ($_GET['acao']=='deixarDeSeguir') {
				Usuarios::seguir_ou_deixarDeSeguir("deixarDeSeguir",$id_usuario,$_GET['id_seguir']);
				header("Location:\seguir");
			}
			
		}

		
		$this->render("quemSeguir");

	}







}

?>