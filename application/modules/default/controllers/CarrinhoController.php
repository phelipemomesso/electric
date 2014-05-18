<?php

class CarrinhoController extends Zend_Controller_Action {

    public function init() {

        $this->Model_Produto        = new Model_Produto();
        $this->Model_Pedido         = new Model_Pedido();
        $this->Model_PedidoProduto  = new Model_PedidoProduto();
        $this->Model_Cliente        = new Model_Cliente();
        
        $this->ValidateInputUrl     = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog             = new Momesso_Plugins_ErrorLog();
        $this->Boleto               = new Momesso_Plugins_Boleto();

        $this->SessionCarrinho      = new Momesso_Plugins_SessionWrapper();

        $this->view->headTitle()->append('Carrinho');
        $this->view->tituloPagina = 'Carrinho';

        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $this->_helper->FlashMessenger->clearMessages();
        }

    }

    public function indexAction(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $this->view->carrinho = $carrinho;
    }


    public function addAction() {
        
    	$this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $this->startPedido();

        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {
    
                $dados = $this->_request->getPost();

                $produto = $this->Model_Produto->getProductById($dados['cod_produto']);

                $existe = false;

                $n = count($carrinho);

                for ($i=0; $i < $n ; $i++) { 
                    
                    if ($carrinho[$i]['cod_produto'] == $dados['cod_produto']) {

                        $carrinho[$i]['qtde']               = $carrinho[$i]['qtde'] + $dados['qtde'];
                        $carrinho[$i]['preco_varejo']       = $produto['preco_varejo'];  
                        $carrinho[$i]['preco_atacado']      = $produto['preco_atacado'];  
                        $carrinho[$i]['preco_distribuidor'] = $produto['preco_distribuidor'];
                        $carrinho[$i]['peso']               = $produto['peso'];
                        $carrinho[$i]['quantidade']         = $produto->quantidade - $dados['qtde'];    

                        $existe = true;

                        $this->qtdeProdutoEstoque(1,$dados['cod_produto'],$produto->quantidade,$dados['qtde']);
                    }
                }

                if (!$existe) {

                    $carrinho[] = array( 
                        'cod_produto' =>$dados['cod_produto'], 
                        'qtde' => $dados['qtde'], 
                        'produto' => $produto['nome'],
                        'preco_varejo' => $produto['preco_varejo'],
                        'preco_atacado' => $produto['preco_atacado'],
                        'preco_distribuidor' => $produto['preco_distribuidor'],
                        'peso' => $produto['peso'],
                        'imagem' => $produto['imagem'],
                        'quantidade' => $produto->quantidade - $dados['qtde'],
                    );

                    $this->qtdeProdutoEstoque(1,$dados['cod_produto'],$produto->quantidade,$dados['qtde']);
                }

                $sess->emptySess();
                $sess->setSessVar('carrinho',$carrinho);
                $this->saveItensCarrinho();

            } 
        }       
    }

    public function updateAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {

                $dados = $this->_request->getPost();

                $produto = $this->Model_Produto->getProductById($dados['cod_produto']);

                $n = count($carrinho);

                for ($i=0; $i < $n ; $i++) { 
                    
                    if ($carrinho[$i]['cod_produto'] == $dados['cod_produto']) {

                        $carrinho[$i]['qtde']       = $dados['qtde']; 
                    }
                }

                $sess->emptySess();
                $sess->setSessVar('carrinho',$carrinho);

            } 
        }       
    }

    public function deleteAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');


        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {
    
                $dados = $this->_request->getPost();

                $produto = $this->Model_Produto->getProductById($dados['cod_produto']);

                $n = count($carrinho);

                for ($i=0; $i < $n ; $i++) { 
                    
                    if ($carrinho[$i]['cod_produto'] == $dados['cod_produto']) {

                        $this->qtdeProdutoEstoque(2,$dados['cod_produto'],$produto->quantidade,$carrinho[$i]['qtde']);
                        
                        $produto = $this->Model_PedidoProduto->verificaPedidoProduto($sessionCustomer->codigoPedido,$carrinho[$i]['produto']);
                        $produto->delete();
                        
                        unset($carrinho[$i]);
                    }
                }

                $i = 0;
                
                foreach ($carrinho as $v) {
                    
                   $carrinhoTmp[$i] = $v;

                   $i++;

                }

                $sess->emptySess();
                $sess->setSessVar('carrinho',$carrinhoTmp);

            } 
        }       
    }

    public function disponibilidadeAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {

                $dados = $this->_request->getPost();

                $produto = $this->Model_Produto->getProductById($dados['cod_produto']);

                if ($produto->quantidade >= $dados['qtde']) {
                    echo 1;
                } elseif ($produto->quantidade < $dados['qtde']) {
                    echo 2;
                }
            } 
        }       
    }


    public function clearAction(){

        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->emptySess();

    }

    
    public function finalizaAction(){

        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        if ($sessionCustomer->id) {

            $this->_redirect('/carrinho/pagar');

        } else {
            
            $this ->_helper->FlashMessenger('Você precisa entrar com sua conta para continuar a compra.'); 
            $this->_redirect('/login');

        }    

    }

    public function pagarAction(){


        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $this->view->carrinho = $carrinho;

    }


    public function paypalAction(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        if (count($carrinho) > 0) {
            
            $dados['valor']         = $this->getTotalCarrinho();
            $dados['pagamento']     = 'PayPal';
            $dados['frete']         = $sessionCustomer->frete;
            $dados['frete_tipo']    = $sessionCustomer->tipoFrete;
            $dados['status']        = 1;

            $idInsert = $this->Model_Pedido->save($dados,$sessionCustomer->codigoPedido);

        } else {

            $this->_redirect('/index');
        }
    }

    public function paypalretornoAction(){

        $this->view->Retorno = $this->_getParam('status');
    }

    public function boletoAction(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        if (count($carrinho) > 0) {
            
            $dados['valor']         = $this->getTotalCarrinho();
            $dados['nosso_numero']  = $this->Model_Pedido->getNossoNumero();
            $dados['criptografia']  = md5($dados['nosso_numero']);
            $dados['pagamento']     = 'Boleto';
            $dados['frete']         = $sessionCustomer->frete;
            $dados['frete_tipo']    = $sessionCustomer->tipoFrete;
            $dados['status']        = 1;

            $this->Model_Pedido->save($dados,$sessionCustomer->codigoPedido);

            $pedido = $this->Model_Pedido->getPedidoById($sessionCustomer->codigoPedido);

            $this->view->Pedido = $pedido->pedido_numero;
            $this->view->Boleto = $pedido->criptografia;

            unset($sessionCustomer->codigoPedido,$sessionCustomer->frete);
            $sess->emptySess(); 

        } else {

            $this->_redirect('/index');
        }
        
    }

    public function imprimeboletoAction(){

        $this->view->layout()->disableLayout();

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        $r = $this->Model_Pedido->getPedidoByCriptografia($this->_getParam('boleto'));
     
        $this->Boleto->data_processamento   = $r['created_at'];
        $this->Boleto->data_vencimento      = $r['dt_vencimento_boleto'];
        $this->Boleto->nosso_numero         = $r['nosso_numero'];
        $this->Boleto->valor                = $r['valor'] + $r['frete'];

        $cliente = $this->Model_Cliente->getClientById($sessionCustomer->id);

        $this->Boleto->documento            = $cliente['documento'];
        $this->Boleto->sacado               = $cliente['fantasia'];
        $this->Boleto->endereco_sacado1     = $cliente['endereco'].' - '.$cliente['numero'].' / '.$cliente['complemento'];
        $this->Boleto->endereco_sacado2     = $cliente['cidade'].' / '.$cliente['estado'];

        $this->view->Boleto = $this->Boleto->Boleto();
        
    }

    public function depositoAction(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        if (count($carrinho) > 0) {
            
            $dados['valor']         = $this->getTotalCarrinho();
            $dados['pagamento']     = 'Depósito';
            $dados['frete']         = $sessionCustomer->frete;
            $dados['frete_tipo']    = $sessionCustomer->tipoFrete;
            $dados['status']        = 1;

            $this->Model_Pedido->save($dados,$sessionCustomer->codigoPedido);

            $pedido = $this->Model_Pedido->getPedidoById($sessionCustomer->codigoPedido);

            $this->view->Total = $this->getTotalCarrinho() + $pedido->frete;
            $this->view->Pedido = $pedido->pedido_numero;

            unset($sessionCustomer->codigoPedido,$sessionCustomer->frete);
            $sess->emptySess();    

        } else {

            $this->_redirect('/index');
        }
       
    }

    public function freteAction() {
        
        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {

                $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');
    
                $dados = $this->_request->getPost();

                $dados['valorFrete'] = str_replace(',', '.',$dados['valorFrete'] );   

                $sessionCustomer->frete         =  $dados['valorFrete'];
                $sessionCustomer->tipoFrete     =  $dados['tipoFrete'];

                echo '<b>R$ '.number_format($dados['valorFrete'] + $dados['valorCompra'], 2, ',', '.').'</b>';
            }
            
        }        

    }    

    private function startPedido(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');
        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        $n = $carrinho;

        if ($carrinho == 0 and !$sessionCustomer->codigoPedido) {
        

            $dados['cliente']       = $sessionCustomer->id;
            $dados['pedido_numero'] = date('dHis').$sessionCustomer->id;
            $dados['status']        = 0;

            $idInsert = $this->Model_Pedido->save($dados);

            $sessionCustomer->codigoPedido = $idInsert;
            
        }
    }


    private function getTotalCarrinho(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        $total = 0;

        if ($sessionCustomer->id) {

            $valor = $this->getGrupoValorByCliente();

            $n = count($carrinho);

            for ($i=0; $i < $n ; $i++) { 

                $total = $total + $carrinho[$i][$valor]*$carrinho[$i]['qtde'];
        
            }   

            return $total;   

        } 
           
    }

    private function saveItensCarrinho(){

        $sess = $this->SessionCarrinho->getInstance();
        $carrinho = $sess->getSessVar('carrinho');

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        $total = 0;

        if ($sessionCustomer->id) {

           $valor = $this->getGrupoValorByCliente(); 

            $n = count($carrinho);

            for ($i=0; $i < $n; $i++) { 

                $produto = $this->Model_PedidoProduto->verificaPedidoProduto($sessionCustomer->codigoPedido,$carrinho[$i]['produto']);


                $dados['pedido']        = $sessionCustomer->codigoPedido;
                $dados['produto']       = $carrinho[$i]['produto'];
                $dados['valor']         = $carrinho[$i][$valor];
                $dados['quantidade']    = $carrinho[$i]['qtde'];


                if ($produto->cod) {

                    $this->Model_PedidoProduto->save($dados,$produto->cod);

                } else {

                    $this->Model_PedidoProduto->save($dados);

                }
                
                unset($dados);
            }

        }
   
    }

    private function getGrupoValorByCliente(){

        $sessionCustomer = new Zend_Session_Namespace('sessionCustomer');

        switch ($sessionCustomer->grupo) {
            case 1:
            $valor = 'preco_varejo';
            break;

            case 2:
            $valor = 'preco_atacado';
            break;

            case 3:
            $valor = 'preco_distribuidor';
            break; 
        }

        return $valor;

    }

    private function qtdeProdutoEstoque($acao,$produto,$qtdeAtual,$qtdeCarrinho){

        // remover quantidade
        if ($acao == 1) {

            $dados['quantidade'] = $qtdeAtual - $qtdeCarrinho;

            $this->Model_Produto->save($dados,$produto);
            
        } elseif ($acao == 2) { // devolver quantidade ao estoque
            
            $dados['quantidade'] = $qtdeAtual + $qtdeCarrinho;

            $this->Model_Produto->save($dados,$produto);
        }

    }
	
}

