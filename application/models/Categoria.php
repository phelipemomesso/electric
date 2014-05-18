<?php

class Model_Categoria {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_ProdutoCategoria();
    }

    public function getCategories($situacao = false,$position){

    	if(!$situacao)
    		$situacao = null;

    	return $this->_dbTable->fetchAll($situacao,$position);
    }
    
    public function getCategoryById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_categoria = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
