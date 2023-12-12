<?php
namespace MF\Model;
use App\Conection;

abstract class Model{
	protected $conexao;

	public function __construct(){
		$this->conexao=Conection::conectar();
	}

}




?>