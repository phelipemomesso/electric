<?php

class CadastroController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_Cliente();
        $this->Model_Logradouro = new Model_Logradouro();

        $this->Form_PF = new Momesso_Default_Form_Clientes_Fisica();
        $this->Form_PJ = new Momesso_Default_Form_Clientes_Juridica();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }

    }


    public function fisicaAction() {
        
    	$translate = Zend_Registry::get('Zend_Translate');
		$this->view->headTitle()->append($translate->translate('Cadastre-se'));
		
    	$this->view->tituloPagina = $translate->translate('Cadastre-se');

    	$this->view->Form = $this->Form_PF;
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form_PF->isValid($dados)) {
    
    			unset($dados['Gravar']);
    
    			try {
    				
    				
                    $dados['senha']         = md5($dados['senha']);
                    $dados['updated_at']    = date('Y-m-d H:i:s');

                    $r = $this->Model->save($dados);

                    $sessionCustomer            = new Zend_Session_Namespace('sessionCustomer');
                    $sessionCustomer->id        = $r;
                    $sessionCustomer->nome      = $dados['fantasia'];
                    $sessionCustomer->usuario   = $dados['email'];
                    $sessionCustomer->grupo     = 1;

                    $this->_helper->FlashMessenger('Dados salvos com sucesso!');

                    $this->_redirect('produto/category/tintas-para-tatuagem/Mg==');
    
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

    public function juridicaAction() {
        
        $translate = Zend_Registry::get('Zend_Translate');
        $this->view->headTitle()->append($translate->translate('Cadastre-se'));
        
        $this->view->tituloPagina = $translate->translate('Cadastre-se');

        $this->view->Form = $this->Form_PJ;
    
        if ($this->_request->isPost()) {
    
            $dados = $this->_request->getPost();
    
            if ($this->Form_PJ->isValid($dados)) {
    
                unset($dados['Gravar']);
    
                try {
                    
                    $dados['senha']         = md5($dados['senha']);
                    $dados['updated_at']    = date('Y-m-d H:i:s');

                    $r = $this->Model->save($dados);

                    $sessionCustomer            = new Zend_Session_Namespace('sessionCustomer');
                    $sessionCustomer->id        = $r;
                    $sessionCustomer->nome      = $dados['fantasia'];
                    $sessionCustomer->usuario   = $dados['email'];
                    $sessionCustomer->grupo     = 1;
    
                    $this->_helper->FlashMessenger('Dados salvos com sucesso!');

                    $this->_redirect('produto/category/tintas-para-tatuagem/Mg==');
    
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


    public function consultacepAction() {

        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $cep = $this->_getParam('cep');
        $cep_temp = str_replace('-', '', $cep);

        $r = $this->Model_Logradouro->getLogradouroByCep($cep_temp);

        if (empty($r['cep'])) {
            
            echo 0;

        } else {
            
            echo '1+'.$r['tipo'].' '.$r['endereco'].'+'.$r['bairro'].'+'.$r['cidade'].'+'.$r['estado'];
        }

    }

	
}

