<?php
/**
* This helper is used to get the base URL
* of the application. It�s useful to call
* CSS styles and JavaScript files, for example.
*/
class Zend_View_Helper_DataHora {
	function DataHora($data){
		$date = new Zend_Date($data);
		return $date->toString('dd/MM/YYYY H:m:s');
	}
}