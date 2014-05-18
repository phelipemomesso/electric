<?php

class Momesso_Default_Form_Clientes_JuridicaU extends EasyBib_Form {

        public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        
        $pessoa = $this->createElement('hidden', 'tipo');
        $pessoa->setValue('J');
        $pessoa->removeDecorator('Label');
        $this->addElement($pessoa);   

        $razao_social = $this->createElement('text', 'razao_social', array('label' => 'Razão Social: '))
                     ->setRequired(true)
                     ->addFilter('StripTags')
                     ->addFilter('stringTrim')
                     ->setAttrib('maxlength', 100)
                        ->setAttrib('size', 100);
        $this->addElement ( $razao_social );

        $fantasia = $this->createElement('text', 'fantasia', array('label' => 'Fantasia: '))
                     ->setRequired(true)
                     ->addFilter('StripTags')
                     ->addFilter('stringTrim')
                     ->setAttrib('maxlength', 100)
                     ->setAttrib('size', 100);
        $this->addElement ( $fantasia );
            
        $cnpj = $this->createElement('text', 'documento', array('label' => 'CNPJ ( Somente números ) : '))
                     ->setRequired(true)
                     ->addFilter('StripTags')
                     ->addFilter('stringTrim')
                     ->setAttrib ( 'maxlength', 18 )
                     ->setAttrib('size', 18)
                     ->setAttrib('class', 'cnpj');
        $this->addElement ( $cnpj );

       	$cep = $this->createElement('text','cep',array('label'=>'CEP ( Somente números ) :'));
       	$cep->setRequired(TRUE)
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 8 )
                ->setAttrib ( 'maxlength', 10 );
       	$this->addElement($cep);

       	$endereco = $this->createElement('text','endereco',array('label'=>'Endereço :'));
       	$endereco->setRequired(TRUE)
                ->addValidator ( 'stringLength', false, array (2, 100 ) )
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 50 )
                ->setAttrib ( 'maxlength', 100 );
       	$this->addElement($endereco);

        $numero = $this->createElement('text','numero',array('label'=>'Número :'));
       	$numero->setRequired(TRUE)
                ->addValidator ( 'stringLength', false, array (1, 6 ) )
                ->addFilter ( 'Digits' )
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 6 )
                ->setAttrib ( 'maxlength', 6 );
       	$this->addElement($numero);

        $complemento = $this->createElement('text','complemento',array('label'=>'Complemento :'));
       	$complemento->setRequired(FALSE)
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 20 )
                ->setAttrib ( 'maxlength', 20 );
       	$this->addElement($complemento);

       	$bairro = $this->createElement('text','bairro',array('label'=>'Bairro :'));
       	$bairro->setRequired(TRUE)
                ->addValidator ( 'stringLength', false, array (2, 50 ) )
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 50 )
                ->setAttrib ( 'maxlength', 50 );
       	$this->addElement($bairro);

       	$cidade = $this->createElement('text','cidade',array('label'=>'Cidade :'));
       	$cidade->setRequired(TRUE)
                ->addValidator ( 'stringLength', false, array (2, 50 ) )
                ->addFilter ( 'StripTags' )
                ->addFilter ( 'StringTrim' )
                ->setAttrib ( 'size', 50 )
                ->setAttrib ( 'maxlength', 50 );
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
                ->setMultiOptions($estadoOptions);
       	$this->addElement($estado);

        $email = $this->createElement('text', 'email', array('label' => 'E-mail: '))
                     ->setRequired(TRUE)
                     ->addValidator ( 'EmailAddress' )
                     ->addFilter('StripTags')
                     ->addFilter('stringTrim')
                     ->setAttrib ( 'maxlength', 50 )
                     ->setAttrib('size', 50);
        $this->addElement ( $email );

        $telefone_fixo = $this->createElement('text', 'telefone_fixo', array('label' => 'Telefone Fixo ( Somente números ) : '))
                         ->setRequired(false)
                         ->addFilter('StripTags')
                         ->addFilter('stringTrim')
                         ->setAttrib ( 'maxlength', 14 )
                         ->setAttrib('size', 14)
                         ->setAttrib('class', 'telefone');
        $this->addElement ( $telefone_fixo );

        $telefone_celular = $this->createElement('text', 'telefone_celular', array('label' => 'Telefone Celular ( Somente números ) : '))
                         ->setRequired(false)
                         ->addFilter('StripTags')
                         ->addFilter('stringTrim')
                         ->setAttrib ( 'maxlength', 14 )
                         ->setAttrib('size', 14);
        $this->addElement ( $telefone_celular );


        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn-primary btn-sm')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');

    }
	
}
