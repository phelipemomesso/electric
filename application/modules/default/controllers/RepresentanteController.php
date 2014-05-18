<?php

class RepresentanteController extends Zend_Controller_Action {

    public function indexAction() {
        
    	$translate = Zend_Registry::get('Zend_Translate');
		$this->view->headTitle()->append($translate->translate('Representantes'));
		
    	$this->view->tituloPagina = 'Representantes';
    	
    	$this->Model = new Model_Representante();
    	
    	$this->view->Data = $this->Model->getRepresentantes('situacao = 1',array('cidade','estado','nome'));

    }

    public function pontoAction(){

        $this->Model = new Model_Representante();

        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();

        $res = $this->Model->getRepresentantes('situacao = 1',array('estado','cidade','nome'));

        //print_r($res);

        $repre='';

        foreach ($res as $v):
            $response[] = array(
                'Id' => $v->cod_representante,
                'Latitude' => $v->latitude,
                'Longitude' => $v->longitude,
                'Titulo' => $v->nome,
                'Descricao' => nl2br($v->texto)
            );
        endforeach;

        echo Zend_Json::encode($response);
    }

	
}

