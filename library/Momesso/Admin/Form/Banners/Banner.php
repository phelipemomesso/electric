<?php

class Momesso_Admin_Form_Banners_Banner extends EasyBib_Form {

	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 100)
                        ->setAttrib('size', 50)
                        ->setAttrib('class', 'span12');
        $this->addElement($nome);
        
        $link = $this->createElement('text', 'link', array('label' => 'Link: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 255)
				        ->setAttrib('size', 50)
				        ->setAttrib('class', 'span12');
        $this->addElement($link);

        $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem:'));
       	$arquivo->setRequired(true)
       		   ->addValidator('Count', false, 1)
       		   ->addValidator('Size', false, '900kb')
       		   ->addValidator('Extension', false, 'jpg,gif');
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
                ->setMultiOptions($statusOptions)
                ->setAttrib('class', 'span2');
        $this->addElement($status);

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
