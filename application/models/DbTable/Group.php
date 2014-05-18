<?php

class Model_DbTable_Group extends Zend_Db_Table_Abstract {

    protected $_name = 'mod_groups';
    protected $_primary = 'cod_group';
    protected $_dependentTables = array('Model_DbTable_Role');
    
}

