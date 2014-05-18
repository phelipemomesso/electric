<?php

class Model_ProdutoGrupo {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_ProdutoGrupo();
    }

    public function getGrupos(){


    	return $this->_dbTable->fetchAll(null,array('position','nome'));
    }

    public function getGruposByCategoriaId($id){


        return $this->_dbTable->fetchAll('situacao = 1 and categoria ='.$id ,array('position','nome'));
    }
    
    public function getGrupoById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_grupo = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
