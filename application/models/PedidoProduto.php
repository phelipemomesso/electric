<?php

class Model_PedidoProduto {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_PedidoProduto();
    }


    public function getProdutosByPedidoId($id){

        return $this->_dbTable->fetchAll('pedido ='.$id,'quantidade asc');
    }

    public function verificaPedidoProduto($pedido,$produto){

        return $this->_dbTable->fetchRow('pedido ='.$pedido.' and produto = "'.addslashes($produto).'"');
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
