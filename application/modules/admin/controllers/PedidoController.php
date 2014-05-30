<?php

class Admin_PedidoController extends Zend_Controller_Action {

    public function init() {

        $this->Model_Pedido         = new Model_Pedido();
        $this->Model_PedidoProduto  = new Model_PedidoProduto();
        $this->Model_Cliente        = new Model_Cliente();
        $this->Model_Produto        = new Model_Produto();
        
        $this->Form                 = new Momesso_Admin_Form_Pedido_Pedido();
        
        $this->ValidateInputUrl     = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog             = new Momesso_Plugins_ErrorLog();
        $this->ExcelReader          = new PHPExcel_Reader_Excel5();

    }

    public function indexAction() {

    	$status = $this->ValidateInputUrl->validateInput($this->_getParam('status'));

        switch ($status) {
            case 0:
                $res = $this->Model_Pedido->getPedidos('status = 0');
                break;

            case 1:
                $res = $this->Model_Pedido->getPedidos('status = 1');
                break; 

            case 2:
                $res = $this->Model_Pedido->getPedidos('status = 2');
                break; 

            case 3:
                $res = $this->Model_Pedido->getPedidos('status = 3');
                break; 

            case 4:
                $res = $this->Model_Pedido->getPedidos('status = 4');
                break;

            case 5:
                $res = $this->Model_Pedido->getPedidos('status = 5');
                break;

            case 7:
                $res = $this->Model_Pedido->getPedidos('status = 7');
                break;                      
            
            default:
                $res = $this->Model_Pedido->getPedidos('status = 0');
                break;
        }

        $paginas = Zend_Paginator::factory($res);
        $paginas->setCurrentPageNumber($this->_getParam('pagina'), 1);
        $paginas->setItemCountPerPage(20);
        $paginas->setPageRange(10);

        $this->view->Data = $paginas;
        $this->view->Status = $status;

        // Retorna a quantidade de registros
        $this->qtdePedidos();
        
    }

    public function buscaAction(){

        $q = $this->ValidateInputUrl->validateInput($this->_getParam('q'));

        $this->view->Query = $q;
        $this->view->Data = $this->Model_Pedido->getPedidos('pedido_numero like "%'.$q.'%"');
        $this->qtdePedidos();
    }
    
    public function retornoAction(){
        
        $this->view->Aberto = $this->Model_Pedido->getPedidos('status = 0 and created_at <= "'.date('Y-m-d H:i:s',strtotime("-7 hours")).'" ');

         $this->view->NPagos = $this->Model_Pedido->getPedidos('status = 1 and created_at <= "'.date('Y-m-d H:i:s',strtotime("-3 days")).'" ');

        /*echo date('Y-m-d H:i:s',strtotime("-3 hours")), "\n";

        $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
         
        if( is_numeric($Id)) {
        
            $pedido     =  $this->Model_Pedido->getPedidoById($Id);
            $produtos   = $this->Model_PedidoProduto->getProdutosByPedidoId($Id);
            
            foreach ($produtos as $v) {
                
                $produto = $this->Model_Produto->getProductByName($v->produto);

                $dados['quantidade'] = $produto->quantidade + $v->quantidade;

                $this->Model_Produto->save($dados,$produto->cod_produto);

            }

            unset($dados);

            $dados['retorno_data_hora'] = date('Y-m-d H:i:s'); 
            $dados['status']            = 6;
            $dados['retorno_estoque']   = 1;

            $this->Model_Pedido->save($dados,$Id);
        }*/
        
    }

    public function infoAction(){
        
        
        $this->view->layout()->disableLayout();

        $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
         
        if( is_numeric($Id)) {
        
            $pedido =  $this->Model_Pedido->getPedidoById($Id);
            $this->view->Pedido     = $pedido;
            $this->view->Produtos   = $this->Model_PedidoProduto->getProdutosByPedidoId($Id);
            $this->view->Cliente    = $this->Model_Cliente->getClientById($pedido->cliente);
        
        }
        
    }

    public function printpedidoAction(){
        
        
        $this->view->layout()->disableLayout();

        $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
         
        if( is_numeric($Id)) {
        
            $pedido =  $this->Model_Pedido->getPedidoById($Id);
            $this->view->Pedido     = $pedido;
            $this->view->Produtos   = $this->Model_PedidoProduto->getProdutosByPedidoId($Id);
            $this->view->Cliente    = $this->Model_Cliente->getClientById($pedido->cliente);
        
        }
        
    }

	public function editAction(){

    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model_Pedido->getPedidoById($Id);

        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['Gravar']);
                
                try {
                	
                	$this->Model_Pedido->save($dados,$Id);
                	
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


    public function produtoAction(){

        (int) $Id               = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
        $this->view->Pedido     = $this->Model_Pedido->getPedidoById($Id);
        $this->view->Produtos   = $this->Model_PedidoProduto->getProdutosByPedidoId($Id);
    }

    public function produtosaveAction(){

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            
            if ($this->_request->isPost ()) {

                $post = $this->_request->getPost ();

                try {

                    $dados['lote_serie'] = $post['lote_serie'];

                    $this->Model_PedidoProduto->save($dados,$post['id']);
                    
                } catch (Zend_Db_Exception $e) {
                        
                    $this->ErrorLog->setModulo($this->_request->getControllerName());
                    $this->ErrorLog->setAcao($this->_request->getActionName());
                    $this->ErrorLog->setErro($e->getMessage());
                    $this->ErrorLog->recordLog();
                }

            }
        }       

    }


    private function qtdePedidos(){

        $this->view->Aberto         = $this->Model_Pedido->getPedidos('status = 0');
        $this->view->Realizado      = $this->Model_Pedido->getPedidos('status = 1');
        $this->view->Confirmado     = $this->Model_Pedido->getPedidos('status = 2');
        $this->view->Entregue       = $this->Model_Pedido->getPedidos('status = 3');
        $this->view->Enviado        = $this->Model_Pedido->getPedidos('status = 4');
        $this->view->Coleta         = $this->Model_Pedido->getPedidos('status = 5');
        $this->view->Cancelado      = $this->Model_Pedido->getPedidos('status = 7');
    }
    
}