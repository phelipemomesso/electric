<?php
/**
* This helper is used to get the base URL
* of the application. It�s useful to call
* CSS styles and JavaScript files, for example.
*/
class Zend_View_Helper_Banner {
	function Banner($type){
		
		$Model = new Model_Banner();
        $r = $Model->getBannersSiteByType($type);
        return $r;
	}
}