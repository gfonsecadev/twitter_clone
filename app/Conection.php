<?php
namespace App;
class conection{
	public static function conectar(){
		try {
			return new \PDO("mysql:host=localhost;dbname=twitter_clone","root","");
			
		} catch (\PDOException $e) {
			
		}
	}
}

?>