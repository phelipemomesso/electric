<?php

class Admin_TatuadorController extends Zend_Controller_Action {

    public function init() {

        $this->Model 			= new Model_Tatuador();
        $this->Model_Images 	= new Model_GaleriaTatuador();
        
        $this->Form 			= new Momesso_Admin_Form_Tatuador_Tatuador();
        $this->Form_Images 		= new Momesso_Admin_Form_Tatuador_Imagem();
        $this->Form_ImagesEdit 	= new Momesso_Admin_Form_Tatuador_ImagemEdit();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog 		= new Momesso_Plugins_ErrorLog();

    }

    public function indexAction() {

    	$this->view->Data = $this->Model->getTatuadores();
    }
    
    public function newAction(){
    
    	$this->view->Form = $this->Form;
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form->isValid($dados)) {
    
    			unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
    
    			try {
    				
    				$idInsert = $this->Model->save($dados);
    				
    				mkdir(getcwd().'/default/uploads/tatuadores/'.$idInsert.'/', 0777);
    				mkdir(getcwd().'/default/uploads/tatuadores/'.$idInsert.'/galeria/', 0777);
    				mkdir(getcwd().'/default/uploads/tatuadores/'.$idInsert.'/galeria/thumbs/', 0777);
    				
    				$adapter = new Zend_File_Transfer_Adapter_Http();
    				$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
    				$arquivo = 'tatuador.'.$ext[0];
    				
    				if ($ext[0]) {
    				
    					$adapter->addFilter('Rename', array('target' => 'default/uploads/tatuadores/'.$idInsert.'/'.$arquivo, 'overwrite' => true));
    				
    					if ($adapter->receive()) {
    						$this->Model->save(array('imagem' => $arquivo),$idInsert);
    						$img = WideImage::load(getcwd() . '/default/uploads/tatuadores/'.$idInsert.'/'.$arquivo);
    						$img->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$idInsert.'/'.$arquivo);
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
    	$r = $this->Model->getTatuadorById($Id);
        
        $this->view->Form = $this->Form;
        
        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
                unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
                
                try {
                	
                	$this->Model->save($dados,$Id);
                	
                	$adapter = new Zend_File_Transfer_Adapter_Http();
                	$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                	$arquivo = 'tatuador.'. $ext[0];
                	
                	if ($ext[0]) {
                	
                		$adapter->addFilter('Rename', array('target' => 'default/uploads/tatuadores/'.$Id.'/'.$arquivo, 'overwrite' => true));
                	
                		if ($adapter->receive()) {
                			$this->Model->save(array('imagem' => $arquivo),$Id);
                			$img = WideImage::load(getcwd() . '/default/uploads/tatuadores/'.$Id.'/'.$arquivo);
                			$img->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$Id.'/'.$arquivo);
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
    	$r = $this->Model->getTatuadorById($Id);
    	
    	if (!empty($r['imagem'])) {
    		$file = getcwd() . '/default/uploads/tatuadores/'.$r['cod_tatuador'].'/'.$r['imagem'];
    		if (file_exists($file)) {
    			unlink($file);
    		}
    	}
    	
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }


    public function informationAction(){

        $this->view->layout()->disableLayout();
        
        (int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    }
    
    /*
     * Imagens da Galeria
    */
    
    
    public function imagesAction(){
    	 
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    	 
    	if(!empty($Id)){
    		 
    		$this->view->Data = $this->Model_Images->getImagesByTatuadorId($Id);
    		$this->view->Galeria = $Id;
    		
    		$this->view->Tatuador = $this->Model->getTatuadorById($Id);
    
    	} else {
    
    		$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    
    	}
    }
    
    public function imageseditAction() {
    
    	(int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
    
    	$r = $this->Model_Images->getImageById($Id);
    	$this->view->Form = $this->Form_ImagesEdit;
    
    	$this->Form_ImagesEdit->getElement('imagem')->setRequired(false);
    	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
    
    	if ($this->_request->isPost()) {
    
    		$dados = $this->_request->getPost();
    
    		if ($this->Form_ImagesEdit->isValid($dados)) {
    
    			unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
    
    			try {
    
    				$this->Model_Images->save($dados,$Id);
    
    				$adapter = new Zend_File_Transfer_Adapter_Http();
    				@$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
    				$arquivo = time().'.' . $ext[0];
    
    				$imagem['nome'] = $dados['nome'];
    
    				$idInsert = $this->Model_Images->save($imagem);
    
    				if ($ext[0]) {
    
    					if (!empty($r['imagem'])) {
    						$file = getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$r['imagem'];
    						$fileThumbs = getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/thumbs/'.$r['imagem'];
    
    						if (file_exists($file)) {
    							unlink($file);
    						}
    
    						if (file_exists($fileThumbs)) {
    							unlink($fileThumbs);
    						}
    					}
    					 
    					$adapter->addFilter('Rename', array('target' => 'default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$arquivo, 'overwrite' => true));
    					 
    					if ($adapter->receive()) {
    						$this->Model_Images->save(array('imagem' => $arquivo),$Id);
    						$img = WideImage::load(getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$arquivo);
    						$img->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$arquivo);
    						$img->resize(150,113,'outside', 'down')->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/thumbs/'.$arquivo);
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
    
    			$fileCaminho = $baseUrl.'/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$r['imagem'];
    			$file = '<img src="' . $fileCaminho . '" alt="' . $r['imagem'] . '" style="width: 300px; margin-top: 5px;" />';
    			$this->Form_ImagesEdit->setDefault('foto', $file);
    		}
    
    		$this->Form_ImagesEdit->populate($r->toArray());
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
    
    								$imagem['tatuador'] 	= $Id;
    								
    								$idInsert = $this->Model_Images->save($imagem);
    
    								$adapter->addFilter('Rename', array('target' => 'default/uploads/tatuadores/'.$Id.'/galeria/'.$arquivo, 'overwrite' => true));
    
    								if ($adapter->receive($info['name'])) {
    									
    									$this->Model_Images->save(array('imagem' => $arquivo),$idInsert);
    									$img = WideImage::load(getcwd() . '/default/uploads/tatuadores/'.$Id.'/galeria/'.$arquivo);
    									$img->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$Id.'/galeria/'.$arquivo);
    									$img->resize(150,113,'outside', 'down')->saveToFile(getcwd() . '/default/uploads/tatuadores/'.$Id.'/galeria/thumbs/'.$arquivo);
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
    		$file = getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/'.$r['imagem'];
    		$fileThumbs = getcwd() . '/default/uploads/tatuadores/'.$r['tatuador'].'/galeria/thumbs/'.$r['imagem'];
    
    		if (file_exists($file)) {
    			unlink($file);
    		}
    
    		if (file_exists($fileThumbs)) {
    			unlink($fileThumbs);
    		}
    	}
    
    	$r->delete();
    	$this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }
    
   }