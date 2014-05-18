<?php

class TatuadorController extends Zend_Controller_Action {


	public function init() {
		
		
		$this->view->tituloPagina = 'Tatuadores';
		
		$this->Model = new Model_Tatuador();
		$this->Model_Fotos = new Model_GaleriaTatuador();
		
		$this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
		
	}
	
	public function indexAction() {
        
		$this->view->headTitle()->append('Tatuadores');
		$this->view->Data = $this->Model->getTatuadores('situacao = 1');

    }
    
    public function viewAction(){
    	
    	$Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	 
    	(int) $Id = base64_decode($Id);
    	 
    	if( is_numeric($Id)) {
    	
    		$r = $this->Model->getTatuadorById($Id);
    		$this->view->Data = $r;
    		
    		$this->view->Images = $this->Model_Fotos->getImagesByTatuadorId($r->cod_tatuador);
    		
    		$translate = Zend_Registry::get('Zend_Translate');
    		$this->view->headTitle()->append($translate->translate('Tatuadores').' - '.$r->nome);
    	
    	} else {
    		$this->_redirect('/tatuador');
    	}
    	
    }

	
}

