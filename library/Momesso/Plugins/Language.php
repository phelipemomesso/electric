<?php

class Momesso_Plugins_Language extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
    	
    	$translate = Zend_Registry::get('Zend_Translate');
        $locale = Zend_Registry::get('Zend_Locale');
        $session = new Zend_Session_Namespace('language');

        
        $filter = new Zend_Filter_Alpha();
        $param = $filter->filter($this->_request->getParam('lang'));
        
    	if ( $translate->isAvailable( $locale->getLanguage() ) ){
    		$translate->setLocale($param);  

		} else{
    		$translate->setLocale('en');
    		//Zend_Registry::set('Zend_Locale', $param);
		}
    }

}