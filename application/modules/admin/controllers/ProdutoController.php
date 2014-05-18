<?php

class Admin_ProdutoController extends Zend_Controller_Action {

    public function init() {

        $this->Model 			= new Model_Produto();
        $this->Model_Images 	= new Model_ProdutoImagem();
        
        $this->Form 			= new Momesso_Admin_Form_Produtos_Produto();
        $this->Form_Images 		= new Momesso_Admin_Form_Tatuador_Imagem();
        $this->Form_ImagesEdit 	= new Momesso_Admin_Form_Tatuador_ImagemEdit();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog 		= new Momesso_Plugins_ErrorLog();

    }

    public function indexAction() {

    	$this->view->Data = $this->Model->getProducts();
    }
    
    public function newAction(){
    
    	$this->view->Form = $this->Form;
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form->isValid($dados)) {
    
    			unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
    
    			try {
    				
    				$idInsert = $this->Model->save($dados);
    				
    				mkdir(getcwd().'/default/uploads/produtos/'.$idInsert.'/', 0777);
    				mkdir(getcwd().'/default/uploads/produtos/'.$idInsert.'/thumbs/', 0777);
    				
    				$adapter = new Zend_File_Transfer_Adapter_Http();
    				$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
    				$arquivo = 'produto.'.$ext[0];
    				
    				if ($ext[0]) {
    				
    					$adapter->addFilter('Rename', array('target' => 'default/uploads/produtos/'.$idInsert.'/'.$arquivo, 'overwrite' => true));
    				
    					if ($adapter->receive()) {
    						$this->Model->save(array('imagem' => $arquivo),$idInsert);
    						$img = WideImage::load(getcwd() . '/default/uploads/produtos/'.$idInsert.'/'.$arquivo);
    						$img->saveToFile(getcwd() . '/default/uploads/produtos/'.$idInsert.'/'.$arquivo);
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
    	$r = $this->Model->getProductById($Id);
        
        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
                
                try {
                	
                	$this->Model->save($dados,$Id);
                	
                	$adapter = new Zend_File_Transfer_Adapter_Http();
                	$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                	$arquivo = 'produto.'. $ext[0];
                	
                	if ($ext[0]) {
                	
                		$adapter->addFilter('Rename', array('target' => 'default/uploads/produtos/'.$Id.'/'.$arquivo, 'overwrite' => true));
                	
                		if ($adapter->receive()) {
                			$this->Model->save(array('imagem' => $arquivo),$Id);
                			$img = WideImage::load(getcwd() . '/default/uploads/produtos/'.$Id.'/'.$arquivo);
                			$img->saveToFile(getcwd() . '/default/uploads/produtos/'.$Id.'/'.$arquivo);
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
    	$r = $this->Model->getProductById($Id);
    	
    	if (!empty($r['imagem'])) {
    		$file = getcwd() . '/default/uploads/tatuadores/'.$r['cod_tatuador'].'/'.$r['imagem'];
    		if (file_exists($file)) {
    			unlink($file);
    		}
    	}
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
    
    /*
     * Imagens da Galeria
    */
    
    
    public function imagesAction(){
    	 
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	 
    	if(!empty($Id)){
    		 
    		$this->view->Data = $this->Model_Images->getImagesByProdutoId($Id);
    		$this->view->Galeria = $Id;
    		
    		$this->view->Produto = $this->Model->getProductById($Id);
    
    	} else {
    
    		$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    
    	}
    }
    
    
    
    public function imagesnewAction(){
    
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('galeria'));
    
    	if(!empty($Id)){
    		 
    		$this->view->Form = $this->Form_Images;
    
    		if ($this->_request->isPost()) {
    
    			$dados = $this->_request->getPost();
    
    			if ($this->Form_Images->isValid($dados)) {
    
    				unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
    
    				try {
    
    					$adapter = new Zend_File_Transfer_Adapter_Http();
    					$i = 1;
    						
    					foreach ($adapter->getFileInfo() as $info) {
    
    						if (!empty($info['name'])) {
    
    							$adapter = new Zend_File_Transfer_Adapter_Http();
    							$ext = array_reverse(explode(".", strtolower($info['name'])));
    							$arquivo = time().$i.'.' . $ext[0];
    
    							if ($ext[0]) {
    
    								$imagem['produto'] 	= $Id;
    								$imagem['imagem'] 	= $arquivo;
    								
    								$idInsert = $this->Model_Images->save($imagem);
    
    								$adapter->addFilter('Rename', array('target' => 'default/uploads/produtos/'.$Id.'/'.$arquivo, 'overwrite' => true));
    
    								if ($adapter->receive($info['name'])) {
    									
    									$this->Model_Images->save(array('imagem' => $arquivo),$idInsert);
    									$img = WideImage::load(getcwd() . '/default/uploads/produtos/'.$Id.'/'.$arquivo);
    									$img->resize(640,480,'outside')->saveToFile(getcwd() . '/default/uploads/produtos/'.$Id.'/'.$arquivo);
    								}
    							}
    							 
    							$i++;
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
    
    	} else {
    
    		$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    
    	}
    }
    
    public function deleteimageAction(){
    
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	$r = $this->Model_Images->getImageById($Id);
    
    	if (!empty($r['imagem'])) {
    		$file = getcwd() . '/default/uploads/produtos/'.$r['produto'].'/'.$r['imagem'];
    
    		if (file_exists($file)) {
    			unlink($file);
    		}
    	}
    
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
    
   }