<?php

class Momesso_Admin_Form_Produtos_Grupo extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $Model_Categoria = new Model_Categoria();
        $Row = $Model_Categoria->getCategories(false,'nome asc');
        $Dados = array();
        $Dados[''] = '-- Selecione a Categoria --';
        foreach ($Row as $v) {
            $Dados[$v['cod_categoria']] = stripslashes($v['nome']);
        }
        
        $categoria = $this->createElement('select', 'categoria', array('label' => 'Categoria: '));
        $categoria->setRequired(true)
                    ->setMultiOptions($Dados);
        $this->addElement($categoria);

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 50)
                        ->setAttrib('size', 50)
                        ->setAttrib('class', 'span12');
        $this->addElement($nome);

        $posicao = $this->createElement('text', 'position', array('label' => 'Posição: '))
                        ->setRequired(false)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('maxlength', 5)
                        ->setAttrib('size', 5);
        $this->addElement($posicao);

        $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem: Formato: jpg'));
        $arquivo->setRequired(true)
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

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
