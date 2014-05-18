<?php

class UsuarioController extends Zend_Controller_Action {


	public function preDispatch() {

        $r = $this->Model->getClientById($this->sessionCustomer->id);

        $dtOld = date("Y-m-d", strtotime(date('Y-m-d') . "- 60 days"));
        
        $lastUpdate = false;

        if($r->updated_at <= $dtOld)
            $lastUpdate = true;

        if ( (empty($r->updated_at) or $lastUpdate) and Zend_Controller_Front::getInstance()->getRequest()->getActionName() != 'cadastro') {
            
            $this ->_helper->FlashMessenger('Seus dados estão desatualizados por mais de 60 dias. Atualize por favor.'); 
            $this->_redirect('/usuario/cadastro');
        }
    }

    public function init() {
		
		
		$this->Model = new Model_Cliente();
        $this->Model_Logradouro = new Model_Logradouro();
        $this->Model_Pedido = new Model_Pedido();
        $this->Model_PedidoProduto = new Model_PedidoProduto();

        $this->Form_PF = new Momesso_Default_Form_Clientes_FisicaU();
        $this->Form_PJ = new Momesso_Default_Form_Clientes_JuridicaU();

        $this->sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }
		
	}
	
	public function pedidoAction() {
        
		$this->view->tituloPagina = 'Usuário / Meus Pedidos';
		$this->view->Data = $this->Model_Pedido->getPedidosByUserId($this->sessionCustomer->id);

    }

    public function cadastroAction() {

        $this->view->tituloPagina = 'Usuário / Meu Cadastro';
        
        $r = $this->Model->getClientById($this->sessionCustomer->id);

        $this->view->Type = $r->tipo;  

        if ($r->tipo=='F') {

            $form = $this->Form_PF;

        } else {

            $form = $this->Form_PJ;
        }

        $this->view->Form = $form;
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            if ($form->isValid($dados)) {
                
                unset($dados['Gravar']);
                
                try {
                    
                    $dados['updated_at'] = date('Y-m-d H:i:s');

                    $this->Model->save($dados,$this->sessionCustomer->id);
                    
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
        } else {
            $form->populate($r->toArray());
        }

    }
    
    public function viewAction(){
    	
    	$this->view->tituloPagina = 'Usuário / Meus Pedidos';

        $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	 
    	if( is_numeric($Id)) {
    	
    		$this->view->Pedido = $this->Model_Pedido->getPedidoById($Id);
            $this->view->Produtos = $this->Model_PedidoProduto->getProdutosByPedidoId($Id);
    	
    	} else {
    		$this->_redirect('/usuario/pedido');
    	}
    	
    }

	
}

