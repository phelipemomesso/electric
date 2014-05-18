<?php

class Model_Promocao {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Promocao();
    }

    public function getPromocoes($situacao = false){

    	if(!$situacao)
    		$situacao = null;
    	
    	return $this->_dbTable->fetchAll($situacao,'data_cadastro desc');
    }
    
    public function getPromocaoById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_promocao = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
