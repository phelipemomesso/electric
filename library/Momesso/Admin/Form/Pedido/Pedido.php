<?php

class Momesso_Admin_Form_Pedido_Pedido extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
        
        $pedido_numero = $this->createElement('text', 'pedido_numero', array('label' => 'Número Pedido: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('readonly', true)
                        ->setAttrib('size', 20);
        $this->addElement($pedido_numero);

        $valor = $this->createElement('text', 'valor', array('label' => 'Valor: '))
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('stringTrim')
                        ->setAttrib('readonly', true)
                        ->setAttrib('size', 20);
        $this->addElement($valor);


        $statusOptions = array(
            1 => "Pedido realizado",
            2 => "Autorização de pagamento",
            3 => "Preparação para o envio",
            4 => "Transporte do(s) Produto(s)",
            5 => "Entrega do(s) Produto(s)",
            7 => "Cancelado"
        );

        $status = $this->createElement('select', 'status', array('label' => 'Status:'));
        $status->setRequired(TRUE)
                ->setMultiOptions($statusOptions);
        $this->addElement($status);

        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn-primary btn-sm')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
