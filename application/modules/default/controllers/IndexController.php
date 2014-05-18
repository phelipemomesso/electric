<?php

class IndexController extends Zend_Controller_Action {

    public function init(){

    	$this->Model_Tatuador = new Model_Tatuador();
    	$this->Model_Destaque = new Model_Destaque();

    }


    public function indexAction() {
        
    	$this->view->headTitle()->append('Home');

    	$this->view->Tatuadores = $this->Model_Tatuador->getTatuadores('situacao = 1');

    	$this->view->Destaques = $this->Model_Destaque->getDestaques('situacao = 1');
		
    }	
}

