<?php

class Model_Cliente {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Cliente();
    }

    public function getClients(){

    	return $this->_dbTable->fetchAll();
    }
    
    public function getClientById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }

    public function getClientByEmail($email){

        return $this->_dbTable->fetchRow('email = "'.$email.'"');
    }

    public function getClientByEmailAndId($email,$id){

        return $this->_dbTable->fetchRow('email = "'.$email.'" and cod_cliente <> '.$id);
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_cliente = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
