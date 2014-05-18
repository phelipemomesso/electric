<?php

class Admin_PromocaoController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_Promocao();
        $this->Form = new Momesso_Admin_Form_Promocao_Promocao();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();
    }

    public function indexAction() {

    	$this->view->Data = $this->Model->getPromocoes();
    }
    
    public function newAction(){
    
    	$this->view->Form = $this->Form;
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form->isValid($dados)) {
    
    			unset($dados['Gravar']);
    
    			try {
    				
    				$idInsert = $this->Model->save($dados);
    
    				$this->view->message = 'Dados salvos com sucesso!';
    				$this->view->messageType = 'success';
    
    			} catch (Zend_Db_Exception $e) {
    
    				$this->view->message = 'Houve um erro, tente novamente. <br /><br />'.$e->getMessage();
    				$this->view->messageType = 'error';
    				 
    				$this->ErrorLog->setModulo($this->_request->getControllerName());
    				$this->ErrorLog->setAcao($this->_request->getActionName());
    				$this->ErrorLog->setErro($e->getMessage());
    				$this->ErrorLog->recordLog();
    			}
    		}
    	}
    }

	public function editAction(){

    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model->getPromocaoById($Id);
        
        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['Gravar']);
                
                try {
                	
                	$this->Model->save($dados,$Id);
                  
                    $this->view->message = 'Dados salvos com sucesso!';
                    $this->view->messageType = 'success';
                    
                } catch (Zend_Db_Exception $e) {
                    
                    $this->view->message = 'Houve um erro, tente novamente. <br /><br />'.$e->getMessage();
	                $this->view->messageType = 'error';
	                   	
	                $this->ErrorLog->setModulo($this->_request->getControllerName());
	                $this->ErrorLog->setAcao($this->_request->getActionName());
	                $this->ErrorLog->setErro($e->getMessage());
	                $this->ErrorLog->recordLog();
                }
            }
        } else {
            $this->Form->populate($r->toArray());
        }
    }
    
    public function deleteAction(){
    	
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model->getPromocaoById($Id);
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
    
   }