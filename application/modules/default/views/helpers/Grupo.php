<?php
/**
* This helper is used to get the base URL
* of the application. It�s useful to call
* CSS styles and JavaScript files, for example.
*/
class Zend_View_Helper_Grupo {

	function Grupo($categoria){
		
		$Model = new Model_ProdutoGrupo();
		
		$rs = $Model->getGruposByCategoriaId($categoria);
		
		$html = '';

		if (count($rs) > 0) {
			
			$html = '<ul class="nav nav-list categories" style="margin-left:5px">';
                    
            foreach ($rs as $v) {
            	
            	$html .= '<li>
                        <a href="'.Zend_Controller_Front::getInstance()->getBaseUrl().'/produto/grupo/'. $this->RemoveAcentos($v->nome).'/'.base64_encode($v->cod_grupo).'">
                            '.$v->nome.'
                        </a>    
                    </li>';
            }
                    
            $html .=  '</ul>';

            return $html;
		}

	}

	function RemoveAcentos($str, $replace=null, $delimiter='-') {
        setlocale(LC_ALL, 'en_US.UTF8');
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }
}