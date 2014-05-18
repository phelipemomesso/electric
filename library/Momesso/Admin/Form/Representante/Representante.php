<?php

class Momesso_Admin_Form_Representante_Representante extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Nome do Representante')
                        ->setAttrib('maxlength', 100)
                        ->setAttrib('class', 'form-control');
        $this->addElement($nome);
        
        $cidade = $this->createElement('text','cidade',array('label'=>'Cidade :'));
        $cidade->setRequired(TRUE)
				        ->addValidator ( 'stringLength', false, array (2, 50 ) )
				        ->addFilter ( 'StripTags' )
				        ->addFilter ( 'StringTrim' )
				        ->setAttrib ( 'maxlength', 50 )
				        ->setDecorators ( array ('Contato' ) )
				        ->setAttrib ( 'class', 'form-control' );
        $this->addElement($cidade);
        
        $estadoOptions = array(
        		"" => "--Selecione--",
        		"AC" => "Acre",
        		"AL" => "Alagoas",
        		"AP" => "Amapá",
        		"AM" => "Amazonas",
        		"BA" => "Bahia",
        		"CE" => "Ceará",
        		"DF" => "Distrito Federal",
        		"ES" => "Espiríto Santo",
        		"GO" => "Goiás",
        		"MA" => "Maranhão",
        		"MT" => "Mato Grosso",
        		"MS" => "Mato Grosso do Sul",
        		"MG" => "Minas Gerais",
        		"PA" => "Pará",
        		"PB" => "Paraíba",
        		"PR" => "Paraná",
        		"PE" => "Pernambuco",
        		"PI" => "Piauí",
        		"RJ" => "Rio de Janeiro",
        		"RN" => "Rio Grande do Norte",
        		"RS" => "Rio Grande do Sul",
        		"RO" => "Rondônia",
        		"RR" => "Roraima",
        		"SC" => "Santa Catarina",
        		"SP" => "São Paulo",
        		"SE" => "Sergipe",
        		"TO" => "Tocantins"
        );
        
        $estado = $this->createElement('select','estado',array('label'=>'Estado :'));
        $estado->setRequired(TRUE)
		        ->setMultiOptions($estadoOptions)
		        ->setDecorators ( array ('Contato' ) );
        $this->addElement($estado);

        $latitude = $this->createElement('text', 'latitude', array('label' => 'Latitude: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Latitude')
                        ->setAttrib('maxlength', 30)
                        ->setAttrib('class', 'form-control');
        $this->addElement($latitude);

        $longitude = $this->createElement('text', 'longitude', array('label' => 'Longitude: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Longitude')
                        ->setAttrib('maxlength', 30)
                        ->setAttrib('class', 'form-control');
        $this->addElement($longitude);
        

        $texto = $this->createElement('textarea', 'texto', array('label' => 'Mais Informações: '))
                        ->setRequired(true)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('placeholder', 'Mais Informações sobre o Representante')
                        ->setAttrib('class', 'form-control')
        				->setAttrib('rows', '4');
        $this->addElement($texto);

       $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem: Formato: jpg'));
        $arquivo->setRequired(false)
                        ->addValidator('Count', false, 1)
                        ->addValidator('Size', false, '2mb')
                        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo);
        
        
        $html = new Momesso_Plugins_Htmlform('foto');
        $html->removeDecorator('label');
        $this->addElement($html);

        $statusOptions = array(
            1 => "Publicado",
            0 => "Não Publicado"
        );

        $status = $this->createElement('select', 'situacao', array('label' => 'Situação:'));
        $status->setRequired(TRUE)
                ->setMultiOptions($statusOptions);
        $this->addElement($status);

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn-primary btn-sm')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
