<?php

class Model_GaleriaTatuador {

    public function __construct() {
        
        $this->_dbTable = new Model_DbTable_GaleriaTatuador();
    }

    public function getImagesByTatuadorId($id){

    	return $this->_dbTable->fetchAll('tatuador = '.$id);
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
