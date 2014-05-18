<?php

class Admin_RepresentanteController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_Representante();
        $this->Form = new Momesso_Admin_Form_Representante_Representante();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();

    }

    public function indexAction() {

    	$this->view->Data = $this->Model->getRepresentantes(null,array('estado','cidade','nome'));
    }
    
    public function newAction(){
    
    	$this->view->Form = $this->Form;
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form->isValid($dados)) {
    
    			unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
    
    			try {
    				
    				$idInsert = $this->Model->save($dados);

                    $adapter = new Zend_File_Transfer_Adapter_Http();
                    $ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                    $arquivo = 'representante'.$Id.'.'.$ext[0];
                    
                    if ($ext[0]) {
                    
                        $adapter->addFilter('Rename', array('target' => 'default/uploads/representantes/'.$arquivo, 'overwrite' => true));
                    
                        if ($adapter->receive()) {
                            $this->Model->save(array('imagem' => $arquivo),$idInsert);
                            $img = WideImage::load(getcwd() . '/default/uploads/representantes/'.$arquivo);
                            $img->saveToFile(getcwd() . '/default/uploads/representantes/'.$arquivo);
                        }
                    }
    
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
    	$r = $this->Model->getRepresentanteById($Id);
        
        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
                
                try {
                	
                	$this->Model->save($dados,$Id);

                    $adapter = new Zend_File_Transfer_Adapter_Http();
                    $ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                    $arquivo = 'representante'.$Id.'.'.$ext[0];
                    
                    if ($ext[0]) {
                    
                        $adapter->addFilter('Rename', array('target' => 'default/uploads/representantes/'.$arquivo, 'overwrite' => true));
                    
                        if ($adapter->receive()) {
                            $this->Model->save(array('imagem' => $arquivo),$Id);
                            $img = WideImage::load(getcwd() . '/default/uploads/representantes/'.$arquivo);
                            $img->saveToFile(getcwd() . '/default/uploads/representantes/'.$arquivo);
                        }
                    }
                	
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
    	$r = $this->Model->getRepresentanteById($Id);

        if (!empty($r['imagem'])) {
            $file = getcwd() . '/default/uploads/representantes/'.$r['imagem'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
    
   }