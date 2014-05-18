<?php

class ProdutoController extends Zend_Controller_Action {

    public function init(){
    	
    	$this->Model = new Model_Produto();
        $this->Model_Categoria = new Model_Categoria();
        $this->Model_ProdutoGrupo = new Model_ProdutoGrupo();
    	
    	$this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
    	
    	$this->view->tituloPagina = 'Produtos';

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }
    }
	
	
	public function categoryAction() {
         	
		$Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	
    	(int) $Id = base64_decode($Id);
    	
    	if( is_numeric($Id)) {
    		
    		//$r = $this->Model->getProductsByCategoria('situacao = 1',$Id);
    		//$this->view->Data = $r;

            $this->view->Categoria = $this->Model_Categoria->getCategoryById($Id);
            $this->view->Data = $this->Model_ProdutoGrupo->getGruposByCategoriaId($Id);
    		
    		$translate = Zend_Registry::get('Zend_Translate');
    		$this->view->headTitle()->append($translate->translate('Produtos'));
    		
    	} else {
            $this->_redirect('/index');
        }
		
    }

    public function grupoAction() {
            
        $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
        
        (int) $Id = base64_decode($Id);
        
        if( is_numeric($Id)) {
            
            $r = $this->Model->getProductsByGroupId($Id);
            $this->view->Data = $r;

            $grupo = $this->Model_ProdutoGrupo->getGrupoById($Id);

            $this->view->Categoria = $this->Model_Categoria->getCategoryById($grupo->categoria);
            $this->view->Grupo = $grupo;
            
            $translate = Zend_Registry::get('Zend_Translate');
            $this->view->headTitle()->append($translate->translate('Produtos'));
            
        } else {
            $this->_redirect('/index');
        }
        
    }
    
    public function viewAction() {
    
    	$Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	 
    	(int) $Id = base64_decode($Id);
    	 
    	if( is_numeric($Id)) {
    
    		$r = $this->Model->getProductById($Id);
    		$this->view->Data = $r;

            $this->view->Grupo = $this->Model->getProductsByGroup($r->grupo);
    		
    		$translate = Zend_Registry::get('Zend_Translate');
    		$this->view->headTitle()->append($translate->translate('Produtos'));
    
    	} else {
    		$this->_redirect('/index');
    	}
    
    }
	
}

