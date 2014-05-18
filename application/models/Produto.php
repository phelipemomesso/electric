<?php

class Model_Produto {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Produto();
    }

    public function getProductsByCategoria($situacao = false,$categoria){

    	if($situacao)
    		$situacao = ' and situacao = '.$situacao;

    	return $this->_dbTable->fetchAll('categoria = '.$categoria.$situacao,'nome asc');
    }

    public function getProductsByGroupId($id){

        return $this->_dbTable->fetchAll('situacao = 1 and grupo = '.$id,'nome asc');
    }

    public function getProducts(){

        return $this->_dbTable->fetchAll();
    }

    public function getProductsByGroup($group){

        return $this->_dbTable->fetchAll('situacao = 1 and grupo = '.$group,'nome asc');
    }
    
    public function getProductById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }

    public function getProductByName($name){
        
        return $this->_dbTable->fetchRow('nome = "'.$name.'"');
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_produto = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
