<?php

class NoticiaController extends Zend_Controller_Action {

    public function preDispatch() {

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
        
        if (!$sessionCustomer->id or $sessionCustomer->grupo != 3) {

            $this ->_helper->FlashMessenger('Você precisa estar logado e ser um usuário do tipo Distribuidor.'); 
            $this->_redirect('/login');
        }
    }

    public function init(){
    	
    	$this->Model = new Model_Noticia();
    	
    	$this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }
    	
    	$this->view->tituloPagina = 'Sala de Imprensa';
    }
	
    public function indexAction() {
    
    	$res = $this->Model->getNews('situacao = 1');
    		 
    	$paginas = Zend_Paginator::factory($res);
    	$paginas->setCurrentPageNumber($this->_getParam('pagina'), 1);
    	$paginas->setItemCountPerPage(10);
    	$paginas->setPageRange(10);
    		 
    	$this->view->Data = $paginas;
    	$this->view->Noticias = $res;
    
    }
	
	public function viewAction() {
         	
		$Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	
    	(int) $Id = base64_decode($Id);
    	
    	if( is_numeric($Id)) {
    		
    		$r = $this->Model->getNewsById($Id);
    		$this->view->Noticia = $r;
    		$this->view->headTitle()->append('Notícia-'.$r->titulo);
    		
    	} else {
            $this->_redirect('/noticia');
        }
		
    }
	
}

