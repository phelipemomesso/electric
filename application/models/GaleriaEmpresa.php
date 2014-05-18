<?php

class Model_GaleriaEmpresa {

    public function __construct() {
        
        $this->_dbTable = new Model_DbTable_GaleriaEmpresa();
    }

    public function getImages(){

    	return $this->_dbTable->fetchAll(null,'position asc');
    }

    public function getImageById($id){

        return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_imagem = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
    
       
}
