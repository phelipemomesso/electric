<?php

class Model_Noticia {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Noticia();
    }

    public function getNews($situacao = false,$limite = false){

    	if(!$situacao)
    		$situacao = null;

    	return $this->_dbTable->fetchAll($situacao,'cod_noticia desc',$limite);
    }
    
    public function getNewsById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_noticia = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
    
    public function searchNews($term){
    
    	return $this->_dbTable->fetchAll('titulo like "%'.$term.'%" or texto like "%'.$term.'%"',$this->getOrder());
    }
    
       
}
