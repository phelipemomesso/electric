<?php

class Momesso_Admin_Form_Noticias_Noticia extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $nome = $this->createElement('text', 'titulo', array('label' => 'Título: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 100)
                        ->setAttrib('size', 50)
                        ->setAttrib('class', 'form-control');
        $this->addElement($nome);

        $descricao = $this->createElement('textarea', 'texto', array('label' => 'Texto: '))
                        ->setRequired(true)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('rows', 4)
                        ->setAttrib('class', 'form-control');
        $this->addElement($descricao);

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
