<?php
/**
* This helper is used to get the base URL
* of the application. It�s useful to call
* CSS styles and JavaScript files, for example.
*/
class Zend_View_Helper_Categoria {
	function Categoria(){
		
		$Model = new Model_Categoria();
		
		$rs = $Model->getCategories('situacao = 1','position asc');
		return $rs;
	}
}