<?php

class Model_Destaque {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Destaque();
    }

    public function getDestaques($situacao=false){

       if(!$situacao)
            $situacao = null;

    	return $this->_dbTable->fetchAll($situacao);
    }
    
    public function getDestaqueById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_destaque = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
    
       
}
