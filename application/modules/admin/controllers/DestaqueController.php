<?php

class Admin_DestaqueController extends Zend_Controller_Action {

    public function init() {

        $this->Model = new Model_Destaque();
        $this->Form = new Momesso_Admin_Form_Destaques_Destaque();
        
        $this->ValidateInputUrl = new Momesso_Plugins_ValidateInputUrl();
        $this->ErrorLog = new Momesso_Plugins_ErrorLog();
    }

  
    public function indexAction() {

        $res = $this->Model->getDestaques();

        $paginas = Zend_Paginator::factory($res);
        $paginas->setCurrentPageNumber($this->_getParam('pagina'), 1);
        $paginas->setItemCountPerPage(25);
        $paginas->setPageRange(10);

        $this->view->Data = $paginas;
    }

    public function editAction() {

        (int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));

        $r = $this->Model->getDestaqueById($Id);
        $this->view->Form = $this->Form;

        $this->Form->getElement('imagem')->setRequired(false);
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

        if ($this->_request->isPost()) {
            
        	$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
            	unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);
                
                try {
                    
                	$this->Model->save($dados,$Id);

                    $adapter = new Zend_File_Transfer_Adapter_Http();
                    @$ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                    $arquivo = 'banner'.$Id.'.'.$ext[0];
                    
                    if ($ext[0]) {

                        if (!empty($r['imagem'])) {
                            $file = getcwd() . '/default/uploads/destaques/' . $r['imagem'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }

                        $adapter->addFilter('Rename', array('target' => 'default/uploads/destaques/' . $arquivo, 'overwrite' => true));

                        if ($adapter->receive()) {
                            $this->Model->save(array('imagem' => $arquivo), $Id);
                            $img = WideImage::load(getcwd() . '/default/uploads/destaques/' . $arquivo);
                            $img->saveToFile(getcwd() . '/default/uploads/destaques/' . $arquivo);
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

            	$fileCaminho = $baseUrl.'/default/uploads/destaques/'.$r['imagem'];
                $file = '<img src="' . $fileCaminho . '" alt="' . $r['imagem'] . '" style="width: 300px; margin-top: 5px;" />';
                $this->Form->setDefault('foto', $file);
            }

            $this->Form->populate($r->toArray());
        }
    }

    public function newAction() {
        
    	if ($this->_request->isPost()) {
            
    		$dados = $this->_request->getPost();
            
            if ($this->Form->isValid($dados)) {
                
            	unset($dados['MAX_FILE_SIZE'], $dados['UPLOAD_IDENTIFIER'], $dados['Gravar']);

                try {
                    
                	$idInsert = $this->Model->save($dados);

                    $adapter = new Zend_File_Transfer_Adapter_Http();
                    $ext = array_reverse(explode(".", strtolower($adapter->getFileName())));
                    $arquivo = 'destaque'.$idInsert.'.'.$ext[0];

                    if (isset($arquivo)) {

                        $adapter->addFilter('Rename', array('target' => 'default/uploads/destaques/' . $arquivo, 'overwrite' => true));

                        if ($adapter->receive()) {
                            $this->Model->save(array('imagem' => $arquivo),$idInsert);
                            $img = WideImage::load(getcwd() . '/default/uploads/destaques/' . $arquivo);
                            $img->saveToFile(getcwd() . '/default/uploads/destaques/' . $arquivo);
                        }
                    }

                   	$this->view->message = 'Dados salvos com sucesso!';
    				$this->view->messageType = 'success';
    				
    				$this->view->Form = $this->Form;
    				
                } catch (Zend_Db_Exception $e) {

                	$this->view->message = 'Houve um erro, tente novamente. <br /><br />'.$e->getMessage();
                	$this->view->messageType = 'error';
                		
                	$this->ErrorLog->setModulo($this->_request->getControllerName());
                	$this->ErrorLog->setAcao($this->_request->getActionName());
                	$this->ErrorLog->setErro($e->getMessage());
                	$this->ErrorLog->recordLog();
                
                }
            } else {
                $this->view->Form = $this->Form;
            }
        } else {
            $this->view->Form = $this->Form;
        }
    }

    public function deleteAction() {
        
    	$this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        (int) $Id = $this->ValidateInputUrl->validateInput($this->_getParam('id'));
        $row = $this->Model->getDestaqueById($Id);

        if (!empty($row['imagem'])) {
            $file = getcwd() . '/default/uploads/destaques/' . $row['imagem'];
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $row->delete();
        $this->_redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }

    ###################################

    
}