<?php

class Momesso_Admin_Form_Produtos_Produto extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $Model_Categoria = new Model_Categoria();
        $Row = $Model_Categoria->getCategories();
        $Dados = array();
        $Dados[''] = '-- Selecione a Categoria --';
        foreach ($Row as $v) {
            $Dados[$v['cod_categoria']] = stripslashes($v['nome']);
        }
        
        $categoria = $this->createElement('select', 'categoria', array('label' => 'Categoria: '));
        $categoria->setRequired(true)
                    ->setMultiOptions($Dados);
        $this->addElement($categoria);

        $tipoOptions = array(
            0 => "Unitário",
            1 => "Grupo"
        );

        $tipo = $this->createElement('select', 'tipo', array('label' => 'Tipo:'));
        $tipo->setRequired(TRUE)
                ->setMultiOptions($tipoOptions);
        $this->addElement($tipo);

        $Model_ProdutoGrupo = new Model_ProdutoGrupo();
        $Row = $Model_ProdutoGrupo->getGrupos();
        $Dados = array();
        $Dados[''] = '-- Selecione o Grupo --';
        foreach ($Row as $v) {
            $Dados[$v['cod_grupo']] = stripslashes($v['nome']);
        }
        
        $grupo = $this->createElement('select', 'grupo', array('label' => 'Grupo: '));
        $grupo->setRequired(false)
                    ->setMultiOptions($Dados);
        $this->addElement($grupo);


        $nome = $this->createElement('text', 'nome', array('label' => 'Nome: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Nome do Produto')
                        ->setAttrib('maxlength', 100)
                        ->setAttrib('class', 'form-control');
        $this->addElement($nome);

        $descricao = $this->createElement('textarea', 'descricao', array('label' => 'Descrição: '))
                        ->setRequired(false)
                        ->addFilters(array('stringTrim'))
                        ->setAttrib('placeholder', 'Descrição do Produto')
                        ->setAttrib('class', 'form-control')
        				->setAttrib('rows', '4');
        $this->addElement($descricao);

        $preco_varejo = $this->createElement('text', 'preco_varejo', array('label' => 'Preço Varejo: Ex: 10.80 / 1.25 / 100.50 '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Valor')
                        ->setAttrib('maxlength', 5);
        $this->addElement($preco_varejo);

        $preco_atacado = $this->createElement('text', 'preco_atacado', array('label' => 'Preço Atacado: Ex: 10.80 / 1.25 / 100.50 '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Valor')
                        ->setAttrib('maxlength', 5);
        $this->addElement($preco_atacado);

        $preco_distribuidor = $this->createElement('text', 'preco_distribuidor', array('label' => 'Preço Distribuidor: Ex: 10.80 / 1.25 / 100.50 '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Valor')
                        ->setAttrib('maxlength', 5);
        $this->addElement($preco_distribuidor);

        $altura = $this->createElement('text', 'altura', array('label' => 'Altura (cm) : '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Altura')
                        ->setAttrib('maxlength', 4);
        $this->addElement($altura);

        $largura = $this->createElement('text', 'largura', array('label' => 'Largura (cm) : '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Largura')
                        ->setAttrib('maxlength', 4);
        $this->addElement($largura);

        $comprimento = $this->createElement('text', 'comprimento', array('label' => 'Comprimento (cm) : '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Comprimento')
                        ->setAttrib('maxlength', 4);
        $this->addElement($comprimento);

        $peso = $this->createElement('text', 'peso', array('label' => 'Peso (kg) : '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Peso')
                        ->setAttrib('maxlength', 4);
        $this->addElement($peso);


        $quantidade = $this->createElement('text', 'quantidade', array('label' => 'Quantidade : '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('placeholder', 'Quantidade')
                        ->setAttrib('maxlength', 4);
        $this->addElement($quantidade);
           
        
        $arquivo = $this->createElement('file','imagem',array('label'=>'Imagem : ( 270px X 133px ) / Formato: jpg'));
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
