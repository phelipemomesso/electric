<?php

class Momesso_Admin_Form_Tatuador_ImagemEdit extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');

        $nome1 = $this->createElement('text', 'nome', array('label' => 'Nome Imagem: '))
		        ->setRequired(true)
		        ->addFilter('StripTags')
		        ->addFilter('stringTrim')
		        ->setAttrib('maxlength', 100)
		        ->setAttrib('class', 'span12');
        $this->addElement($nome1);

        
        $arquivo1 = $this->createElement('file','imagem',array('label'=>'Imagem : ( 640px X 480px ) / Formato: jpg'));
        $arquivo1->setRequired(true)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo1);
        
        $html = new Momesso_Plugins_Htmlform('foto');
        $html->removeDecorator('label');
        $this->addElement($html);
       
        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
