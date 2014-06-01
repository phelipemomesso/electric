<?php

class Admin_ClienteController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_Cliente();
        
        $this->Form_PF = new Momesso_Admin_Form_Clientes_Fisica();
        $this->Form_PJ = new Momesso_Admin_Form_Clientes_Juridica();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();
        $this->ExcelReader = new PHPExcel_Reader_Excel5();

    }

    public function indexAction() {

        $grupo = $this->ValidateInputUrl->validateInput($this->_getParam('grupo'));

        switch ($grupo) {
            case 1:
                $res = $this->Model->getClients('grupo = 1');
                break;

            case 2:
                $res = $this->Model->getClients('grupo = 2');
                break; 

            case 3:
                $res = $this->Model->getClients('grupo = 3');
                break;                     
            
            default:
                $res = $this->Model->getClients('grupo = 1');
                break;
        }

        $paginas = Zend_Paginator::factory($res);
        $paginas->setCurrentPageNumber($this->_getParam('pagina'), 1);
        $paginas->setItemCountPerPage(20);
        $paginas->setPageRange(10);

        $this->view->Data = $paginas;
        $this->view->Grupo = $grupo;

        $this->qtdeClientes();
    }

    public function buscaAction(){

        $q = $this->ValidateInputUrl->validateInput($this->_getParam('q'));

        $this->view->Query = $q;
        $this->view->Data = $this->Model->getClients('fantasia like "%'.$q.'%"');
        $this->qtdeClientes();
    }
    
    public function newAction(){
    
    	$type = $this->ValidateInputUrl->validateInput($this->_getParam('type'));

        $this->view->Type = $type;  

        if ($type=='f') {

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
    				
    				$this->Model->save($dados);
    
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
    	$r = $this->Model->getClientById($Id);

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
            $form->populate($r->toArray());
        }
    }
    
    public function deleteAction(){
    	
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model->getClientById($Id);
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }


    public function importAction(){
        
        $this->view->layout()->disableLayout();
        
        $objPHPExcel = $this->ExcelReader->load(getcwd().'/default/uploads/clientes.xls');   

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                            
        $n= count($sheetData);

        /*echo '<pre>';
        print_r($sheetData);
        echo '</pre>';*/

        for ($i=2; $i <= $n ; $i++) { 

            
            $dados['documento']     = $sheetData[$i]['C'];
            $dados['fantasia']      = ucwords(mb_strtolower($sheetData[$i]['E'], 'UTF-8'));
            $dados['email']         = mb_strtolower($sheetData[$i]['B'], 'UTF-8');

            if (strlen($sheetData[$i]['C']) <= 11) {
                $dados['tipo'] = 'F';
            } elseif (strlen($sheetData[$i]['C']) > 11) {
                $dados['tipo'] = 'J';
            }

            $dados['senha']     = md5($sheetData[$i]['D']);
            
            
            $this->Model->save($dados);
        }    
    }

    private function qtdeClientes(){

        $this->view->Varejo         = $this->Model->getClients('grupo = 1');
        $this->view->Atacado        = $this->Model->getClients('grupo = 2');
        $this->view->Distribuidor   = $this->Model->getClients('grupo = 3');
    }

    
   }