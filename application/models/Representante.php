<?php

class Model_Representante {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Representante();
    }

    public function getRepresentantes($situacao = false,$order){

    	if(!$situacao)
    		$situacao = null;

    	return $this->_dbTable->fetchAll($situacao,$order);
    }
    
    public function getRepresentanteById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_representante = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
