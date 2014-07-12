<?php

class NoticiaController extends Zend_Controller_Action {


    public function init(){
    	
    	$this->Model = new Model_Noticia();
    	
    	$this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
    	
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

