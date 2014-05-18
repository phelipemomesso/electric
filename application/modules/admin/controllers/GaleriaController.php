<?php

class Admin_GaleriaController extends Zend_Controller_Action {

    public function init() {

        $this->Model 			= new Model_GaleriaEmpresa();
        $this->Form 		    = new Momesso_Admin_Form_Galeria_Empresa();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog 		= new Momesso_Plugins_ErrorLog();

    }

    public function indexAction() {

    	$this->view->Data = $this->Model->getImages();
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
    				$arquivo = $idInsert.'.'.$ext[0];
    				
    				if ($ext[0]) {
    				
    					$adapter->addFilter('Rename', array('target' => 'default/uploads/empresa/'.$arquivo, 'overwrite' => true));
    				
    					if ($adapter->receive()) {
    						$this->Model->save(array('imagem' => $arquivo),$idInsert);
    						$img = WideImage::load(getcwd() . '/default/uploads/empresa/'.$arquivo);
    						$img->saveToFile(getcwd() . '/default/uploads/empresa/'.$arquivo);
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
    	$r = $this->Model->getImageById($Id);

        $this->Form->getElement('imagem')->setRequired(false);
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        
        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
                
                try {
                	
                	$this->Model->save($dados,$Id);
                	
                	@$adapter = new Zend_File_Transfer_Adapter_Http();
                	$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                	$arquivo = $Id.'.'. $ext[0];
                	
                	if ($ext[0]) {
                	
                		$adapter->addFilter('Rename', array('target' => 'default/uploads/empresa/'.$arquivo, 'overwrite' => true));
                    
                        if ($adapter->receive()) {
                            $this->Model->save(array('imagem' => $arquivo),$Id);
                            $img = WideImage::load(getcwd() . '/default/uploads/empresa/'.$arquivo);
                            $img->saveToFile(getcwd() . '/default/uploads/empresa/'.$arquivo);
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

            if (!empty($r['imagem'])) {

                $fileCaminho = $baseUrl.'/default/uploads/empresa/'.$r['imagem'];
                $file = '<img src="' . $fileCaminho . '" alt="' . $r['imagem'] . '" style="width: 300px; margin-top: 5px;" />';
                $this->Form->setDefault('foto', $file);
            }

            $this->Form->populate($r->toArray());
        }
    }
    
    public function deleteAction(){
    	
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model->getImageById($Id);
    	
    	if (!empty($r['imagem'])) {
    		$file = getcwd() . '/default/uploads/empresa/'.$r['imagem'];
    		if (file_exists($file)) {
    			unlink($file);
    		}
    	}
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }

    
   }