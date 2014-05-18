<?php

class Momesso_Admin_Form_Tatuador_Tatuador extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Nome do Tatuador')
                        ->setAttrib('maxlength', 100)
                        ->setAttrib('class', 'form-control');
        $this->addElement($nome);

        $sobre = $this->createElement('textarea', 'sobre', array('label' => 'Sobre: '))
                        ->setRequired(false)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('placeholder', 'Sobre o Tatuador')
                        ->setAttrib('class', 'form-control')
        				->setAttrib('rows', '4');
        $this->addElement($sobre);
        
        $endereco = $this->createElement('textarea', 'endereco', array('label' => 'Endereço: '))
				        ->setRequired(false)
				        ->addFilters(array('stringTrim'))
				        ->setAttrib('placeholder', 'Endereço do Tatuador')
				        ->setAttrib('class', 'form-control')
				        ->setAttrib('rows', '4');
        $this->addElement($endereco);
        
        $contato = $this->createElement('textarea', 'contato', array('label' => 'Contato ( E-mail / Telefone / Site ): '))
				        ->setRequired(false)
				        ->addFilters(array('stringTrim'))
				        ->setAttrib('placeholder', 'Dados de contato do Tatuador')
				        ->setAttrib('class', 'form-control')
				        ->setAttrib('rows', '4');
        $this->addElement($contato);
        
        $site = $this->createElement('text', 'site', array('label' => 'Site http:// '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('placeholder', 'Site do Tatuador')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'form-control');
        $this->addElement($site);
        
        $facebook = $this->createElement('text', 'facebook', array('label' => 'Facebook http:// '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('placeholder', 'Facebook do Tatuador')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'form-control');
        $this->addElement($facebook);
        
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
                ->setMultiOptions($statusOptions)
                ->setAttrib('class', 'span2');
        $this->addElement($status);

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn-primary btn-sm')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
