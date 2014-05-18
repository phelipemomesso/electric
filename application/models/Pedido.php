<?php

class Model_Pedido {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Pedido();
    }


    public function getPedidos(){

        return $this->_dbTable->fetchAll(null,'created_at desc');
    }

    public function getPedidosByUserId($id){

        return $this->_dbTable->fetchAll('cliente = '.$id,'created_at desc');
    }

    public function getPedidoById($id){
    	
    	return $this->_dbTable->find($id)->current();
    }

    public function getPedidoByCriptografia($criptografia){
        
        return $this->_dbTable->fetchRow('criptografia = "'.$criptografia.'"');
    }

    public function getNossoNumero(){
        
        $r = $this->_dbTable->fetchRow('pagamento = "Boleto"','cod_pedido desc');
        return $r['nosso_numero'] + 1;
    }
    
    public function save($dados,$id=false) {
    
    	if($id)
    		return $this->_dbTable->update($dados, 'cod_pedido = '. $id);
    	else {
    
    		return $this->_dbTable->insert($dados);
    	}
    }
       
}
