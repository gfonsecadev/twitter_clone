<?php
namespace App\Model;
use App\Conection;
use MF\Model\Model;
class Usuarios extends Model{
	private $id_usuario;
	private $nome;
	private $email;
	private $senha;



	public function __get($atr){
		return $this->$atr;
	}

	public function __set($atr,$valor){
		$this->$atr=$valor;
	}


	public function cadastrar(){
		if ($this->verificar_se_cadastrado()) {
			$query="insert into usuarios(nome,email,senha)values(:nome,:email,:senha)";

			$stmt=$this->conexao->prepare($query);
			$stmt->bindValue(":nome",$this->__get("nome"));
			$stmt->bindValue(":email",$this->__get("email"));
			$stmt->bindValue(":senha",$this->__get("senha"));
			$stmt->execute();
			return true;
		}else{
			header("Location:/inscreverse?erro=jaCadastrado");
		}
		

	}

	public function verificar_se_cadastrado(){
		$query="select nome,email from usuarios where nome=:nome and email=:email";
		$stmt=$this->conexao->prepare($query);
		$stmt->bindValue(":nome",$this->__get("nome"));
		$stmt->bindValue(":email",$this->__get("email"));
		$stmt->execute();
		$retorno=$stmt->fetch(\PDO::FETCH_ASSOC);

		if(empty($retorno)){
			return true;
		}else{
			return false;
		}
	}

	public function verificar_autenticidade(){
		$query="select id,email,senha from usuarios where email=:email and senha=:senha";
		$stmt=$this->conexao->prepare($query);
		$stmt->bindValue(":email",$this->__get("email"));
		$stmt->bindValue(":senha",$this->__get("senha"));
		$stmt->execute();
		$retorno=$stmt->fetch(\PDO::FETCH_ASSOC);

		if(!empty($retorno)){
			return $retorno;
		}else{
			return "";
		}
	}


	public function carregar_dados_usuario(){
		$query="select u.id,u.nome,(select  COUNT(tweet) from tweets WHERE id_usuario=u.id)AS quant_tweets,(select  COUNT(id_usuario) from usuarios_seguidores WHERE id_usuario=u.id)AS seguindo,(select  COUNT(id_usuario_seguindo) from usuarios_seguidores WHERE id_usuario_seguindo=u.id)AS seguidores from usuarios AS u  where u.email=:email and u.senha=:senha";
		$stmt=$this->conexao->prepare($query);
		$stmt->bindValue(":email",$this->__get("email"));
		$stmt->bindValue(":senha",$this->__get("senha"));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}


	public function carregar_tweets_usuario(){
		$query="SELECT u.nome,t.id,t.id_usuario,t.tweet,DATE_FORMAT(t.data,'%d/%m/%y  %H:%m:%i') AS data from usuarios as u LEFT JOIN tweets as t ON(u.id=t.id_usuario ) WHERE t.id_usuario=:id_usuario OR t.id_usuario IN(select id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario=:id_usuario) ORDER BY data DESC";
		$stmt=$this->conexao->prepare($query);
		$stmt->bindValue(":id_usuario",$this->__get("id"));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public static  function procurar_usuario($nome,$id_usuario){
		$query="SELECT u.id,u.nome,(SELECT id_usuario_seguindo FROM usuarios_seguidores WHERE id_usuario_seguindo=u.id AND id_usuario=:id_usuario) AS seguindo  FROM usuarios as u WHERE u.nome LIKE :nomeProcurado  AND u.id!=:id_usuario";
		$conexao=Conection::conectar();
		$stmt=$conexao->prepare($query);
		$stmt->bindValue(":nomeProcurado",'%'.$nome.'%');
		$stmt->bindValue(":id_usuario",$id_usuario);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public static  function seguir_ou_deixarDeSeguir($acao,$id_usuario,$id_usuario_seguir){
		if ($acao=="seguir") {
			$query="INSERT INTO usuarios_seguidores(id_usuario,id_usuario_seguindo)VALUES(:id_usuario,:id_usuario_seguir)";
		}else{
			$query="DELETE FROM usuarios_seguidores WHERE id_usuario=:id_usuario AND id_usuario_seguindo=:id_usuario_seguir";
		}
		$conexao=Conection::conectar();
		$stmt=$conexao->prepare($query);
		$stmt->bindValue(":id_usuario",$id_usuario);
		$stmt->bindValue(":id_usuario_seguir",$id_usuario_seguir);
		$stmt->execute();
		
	}

	public static function salvar_tweet($id_usuario,$tweet){
		$query="INSERT INTO tweets(id_usuario,tweet)VALUES(:id_usuario,:tweet)";
		
		$conexao=Conection::conectar();
		$stmt=$conexao->prepare($query);
		$stmt->bindValue(":id_usuario",$id_usuario);
		$stmt->bindValue(":tweet",$tweet);
		$stmt->execute();
	}

}

?>