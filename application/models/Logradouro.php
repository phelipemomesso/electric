<?php

class Model_Logradouro {
	

	public function __construct() {
        
        $this->_dbTable = new Model_DbTable_Logradouro();
    }

    public function getLogradouroByCep($cep) {
        
       $select = $this->_dbTable->select()
                ->setIntegrityCheck(false)
                ->from(array('endereco' => 'mod_correios_logradouro'),array('tipo'=>'endereco.TLO_TX','endereco'=>'endereco.LOG_NO','cep'=>'endereco.CEP'))
                ->from(array('cidade' => 'mod_correios_localidade'),array('cidade'=>'cidade.LOC_NO','estado'=>'cidade.UFE_SG','cod_cidade'=>'cidade.LOC_NU'))
                ->from(array('bairro'=>'mod_correios_bairro'),array('bairro'=>'bairro.BAI_NO'))
                ->where('endereco.BAI_NU_INI = bairro.BAI_NU and cidade.LOC_NU = endereco.LOC_NU and endereco.cep = '.$cep);
       
       return $this->_dbTable->fetchRow($select);

    }
       
}
