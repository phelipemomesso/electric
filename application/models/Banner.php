<?php

class Model_Banner {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Banner();
    }

    public function getBanners(){

    	return $this->_dbTable->fetchAll(null);
    }
    
    public function getBannersSiteByType($type){
    
    	return $this->_dbTable->fetchAll('situacao = 1 and tipo = '.$type,'rand()');
    }
    
    public function getBannerById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_banner = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
    
       
}
