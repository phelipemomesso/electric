<?php

class PromocaoController extends Zend_Controller_Action {

	public function init(){
		 
		$this->Model = new Model_Promocao();
		 
		$this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
		 
		$this->view->tituloPagina = 'Promoções';
	}
	
	public function indexAction() {
    
		$translate = Zend_Registry::get('Zend_Translate');
		$this->view->headTitle()->append($translate->translate('Promoções'));
		
		$res = $this->Model->getPromocoes('situacao = 1');
    		 
    	$paginas = Zend_Paginator::factory($res);
    	$paginas->setCurrentPageNumber($this->_getParam('pagina'), 1);
    	$paginas->setItemCountPerPage(4);
    	$paginas->setPageRange(10);
    		 
    	$this->view->Data = $paginas;
    
    }
	
	public function viewAction() {
         	
		$Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	
    	(int) $Id = base64_decode($Id);
    	
    	if( is_numeric($Id)) {
    		
    		$r = $this->Model->getServiceById($Id);
    		$this->view->Servico = $r;
    		$this->view->headTitle()->append('Serviço-'.$r->titulo);
    		
    	} else {
            $this->_redirect('/servico');
        }
		
    }

	
}

