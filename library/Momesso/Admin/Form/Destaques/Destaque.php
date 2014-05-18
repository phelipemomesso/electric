<?php

class Momesso_Admin_Form_Destaques_Destaque extends EasyBib_Form {

	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(false)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 50)
                       ->setAttrib('class', 'form-control');
        $this->addElement($nome);

        $descricao = $this->createElement('textarea', 'texto', array('label' => 'Texto: '))
                        ->setRequired(false)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('rows', 4)
                        ->setAttrib('class', 'form-control');
        $this->addElement($descricao);
        
        $link = $this->createElement('text', 'link', array('label' => 'Link: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 255)
				        ->setAttrib('class', 'form-control');
        $this->addElement($link);

        $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem (PNG):'));
       	$arquivo->setRequired(false)
       		   ->addValidator('Count', false, 1)
       		   ->addValidator('Size', false, '900kb')
       		   ->addValidator('Extension', false, 'png');
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

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
