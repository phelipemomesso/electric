<?php

class Model_Tatuador {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Tatuador();
    }

    public function getTatuadores($situacao = false){

    	if(!$situacao)
    		$situacao = null;

    	return $this->_dbTable->fetchAll($situacao,'nome asc');
    }
    
    public function getTatuadorById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_tatuador = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
