<?php

class EmpresaController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_GaleriaEmpresa();

    }

    public function indexAction() {
        
    	$translate = Zend_Registry::get('Zend_Translate');
		$this->view->headTitle()->append($translate->translate('A Electric Ink'));
		
    	$this->view->tituloPagina = 'A Electric Ink';

    	$this->view->Data = $this->Model->getImages();
    }

	
}

