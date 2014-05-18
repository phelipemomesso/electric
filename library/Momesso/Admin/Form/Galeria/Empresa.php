<?php

class Momesso_Admin_Form_Galeria_Empresa extends EasyBib_Form {

	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');

        $posicao = $this->createElement('text', 'position', array('label' => 'Posição: '))
                        ->setRequired(false)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 5)
                        ->setAttrib('size', 5);
        $this->addElement($posicao);

        $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem:'));
       	$arquivo->setRequired(false)
       		   ->addValidator('Count', false, 1)
       		   ->addValidator('Size', false, '900kb')
       		   ->addValidator('Extension', false, 'jpg');
    	$this->addElement($arquivo);

    	$html = new Momesso_Plugins_Htmlform('foto');
		$html->removeDecorator('label');
		$this->addElement($html);

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
