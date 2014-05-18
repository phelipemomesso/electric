<?php

class LoginController extends Zend_Controller_Action {

    public function preDispatch() {

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
        
        if ($sessionCustomer->id and Zend_Controller_Front::getInstance()->getRequest()->getActionName() == 'index') {

            
        }    
    }


    public function init() {

        $this->form = new Momesso_Admin_Form_Login_Login();

        $this->Model = new Model_Cliente();
        $this->Form_PF = new Momesso_Default_Form_Clientes_Fisica();
        $this->Form_PJ = new Momesso_Default_Form_Clientes_Juridica();
        $this->Form_Reset = new Momesso_Default_Form_Login_Reset();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }

        $this->view->headTitle()->append('Login');
        $this->view->tituloPagina = 'Login';

    }


    public function indexAction() {
        
        $this->view->form = $this->form;
        
        $this->view->Error = $this->_request->getParam('error');

        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            $this->view->dados = $dados;

            if ($this->form->isValid($dados)) {
                
                @$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'mod_clientes', 'email', 'senha', 'MD5(?)');
                $authAdapter->setIdentity($dados['usuario'])->setCredential($dados['senha']);

                $result = $authAdapter->authenticate();
                
                if ($result->isValid()) {

                    $SessID = md5(uniqid(time()));

                    $auth = Zend_Auth::getInstance();

                    $data = $authAdapter->getResultRowObject(array('cod_cliente', 'email', 'fantasia','grupo'));
                    $auth->getStorage()->write($data);
                    $data->SessID = $SessID;

                    $identify = $auth->getIdentity();
                   
                    $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
                    $sessionCustomer->id = $identify->cod_cliente;
                    $sessionCustomer->nome = $identify->fantasia;
                    $sessionCustomer->usuario = $identify->email;
                    $sessionCustomer->grupo = $identify->grupo;

                    
                    $carrinho = new Zend_Session_Namespace('carrinho');

                    if (count($carrinho) > 1) {

                        $this->_redirect('/carrinho/pagar');

                    } else {

                        $this->lastUpdate();
                    }
    
                    
                } else {
                    
                    switch ($result->getCode()) {
                        
                        case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                            
                            $this ->_helper->FlashMessenger('Usuário não encontrado.');
                            $this->_redirect('/login'); 
                        
                        case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                            
                            $this ->_helper->FlashMessenger('Senha errada.');
                            $this->_redirect('/login'); 
                    }
                }
            }
        }
    }


    public function logoutAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
        $sessionCustomer->unsetAll();

        $sessionCarrinho = new Zend_Session_Namespace('carrinho');
        $sessionCarrinho->unsetAll();

        Zend_Auth::getInstance()->clearIdentity();

        $this->_redirect('/login');
    }

    private function lastUpdate(){

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        $Model = new Model_Cliente();

        $r = $Model->getClientById($sessionCustomer->id);

        $dtOld = date("Y-m-d", strtotime(date('Y-m-d') . "- 60 days"));
            
        $lastUpdate = 0;

        if (empty($r->updated_at)) {
            
            $lastUpdate = 1;

        } else if($r->updated_at <= $dtOld) {
            
            $lastUpdate = 1;

        }

        if ( $lastUpdate == 1 ) {
                
            $this ->_helper->FlashMessenger('Seus dados estão desatualizados por mais de 60 dias. Atualize por favor.'); 
            $this->_redirect('/usuario/cadastro');
        } else {
             $this->_redirect('/produto/category/tintas-para-tatuagem/Mg==');
        }
    }

    public function forgotAction(){

        $Model = new Model_Cliente();

        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
           

            $r = $Model->getClientByEmail($dados['email']);

            if (!empty($r->email)) {

                $this->view->dados = $r;

                $message = $this->view->render('template/password.phtml');

                $headers = "MIME-Version: 1.1\n";
                $headers .= "Content-type: text/html; charset=utf-8\n";
                $headers .= "From:no-responder <gerencia@electricink.com.br>\n"; // remetente
                $headers .= "Reply-To: ".$dados['email']."\n"; // return-path
                $emailsender = 'gerencia@electricink.com.br';

                $ok = mail($dados['email'], "Electric Ink - Recuperar Senha", $message, $headers,"-r".$emailsender);

                if ($ok) {

                    $this ->_helper->FlashMessenger('Senha enviada com sucesso. Verifique seu email.'); 
                    $this->_redirect('/login/forgot');

                } else {

                    $this ->_helper->FlashMessenger('Erro ao enviar a senha. Tente novamente.'); 
                    $this->_redirect('/login/forgot');
                } 
                   

            } else {

                $this ->_helper->FlashMessenger('E-mail não encontrado.'); 
                $this->_redirect('/login/forgot');
            }   
        }
            
    }

    public function resetAction(){

        $Model = new Model_Cliente();
        
        $Id =  base64_decode($this->_request->getParam('id'));

        $r = $Model->getClientById($Id);

        if ($this->_request->isPost()) {

            $dados = $this->_request->getPost();
            $this->view->dados = $dados;

            if ($this->Form_Reset->isValid($dados)) {

                unset($dados['senha2'],$dados['Update']);

                try {

                    $dados['senha'] = md5($dados['senha']);

                    $this->Model->save($dados,$Id);

                    $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
                    
                    if (!$sessionCustomer->id) {
                        
                        $sessionCustomer->id        = $r->cod_cliente;
                        $sessionCustomer->nome      = $r->fantasia;
                        $sessionCustomer->usuario   = $r->email;
                        $sessionCustomer->grupo     = $r->grupo;
                    }

                    $this->Form_Reset->reset();

                    $this ->_helper->FlashMessenger('Senha trocada com sucesso!'); 
                    $this->_redirect('/produto/category/tintas-para-tatuagem/Mg==');

                } catch (Zend_Db_Exception $e) {
                
                    $this->view->message = 'There was an error, please try again. <br /><br />'.$e->getMessage();
                    $this->view->messageType = 'danger';

                }
            }  else {

                $this->view->Form = $this->Form_Reset;
            }
         } else {

            $this->Form_Reset->populate($r->toArray());
            $this->view->Form = $this->Form_Reset;
        }
    }

    public function checkemailAction(){

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {

                $dados = $this->_request->getPost ();

                $sessionCustomer  = new Zend_Session_Namespace('sessionCustomer');

                $r = $this->Model->getClientByEmailAndId($dados['email'],$sessionCustomer->id );

                // E-mail encontrado
                if (count($r) == 1) {
                   
                   echo 1;
                
                } elseif (count($r) == 0) {
                    
                    echo 2;
                }
            }
        }        
    }   

	
}