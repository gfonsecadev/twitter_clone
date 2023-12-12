<?php
namespace MF\Model;

class Container{
	public static function getModel($model){
		$class="\\App\\Model\\".ucfirst($model);
		return new $class;
	}

}


?>