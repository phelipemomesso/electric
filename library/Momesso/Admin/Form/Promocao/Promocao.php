<?php

class Momesso_Admin_Form_Promocao_Promocao extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 50)
                        ->setAttrib('size', 50)
                        ->setAttrib('class', 'span12');
        $this->addElement($nome);
        
        $validade = $this->createElement('text', 'validade', array('label' => 'Validade: '))
				        ->setRequired(true)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 30)
				        ->setAttrib('size', 30)
				        ->setAttrib('class', 'span4');
        $this->addElement($validade);

        $descricao = $this->createElement('textarea', 'descricao', array('label' => 'Texto: '))
                        ->setRequired(true)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('class', 'ckeditor');
        $this->addElement($descricao);

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
