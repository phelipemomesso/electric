<?php

class Momesso_Admin_Form_Tatuador_Imagem extends EasyBib_Form {

    	public function init() {

        $this->setAction('')
                ->setMethod('post')
                ->setAttrib('enctype', 'multipart/form-data')
                ->setAttrib('id', 'form');
           
        /*$nome1 = $this->createElement('text', 'nome1', array('label' => 'Nome Imagem 1: '))
				        ->setRequired(true)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome1);*/
        
        $arquivo1 = $this->createElement('file','imagem1',array('label'=>'Imagem : ( 640px X 480px ) / Formato: jpg'));
        $arquivo1->setRequired(true)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo1);
        
        /*$nome2 = $this->createElement('text', 'nome2', array('label' => 'Nome Imagem 2: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome2);*/
        
        $arquivo2 = $this->createElement('file','imagem2',array('label'=>'Imagem 2 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo2->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo2);
        
        
        /*$nome3 = $this->createElement('text', 'nome3', array('label' => 'Nome Imagem 3: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome3);*/
        
        $arquivo3 = $this->createElement('file','imagem3',array('label'=>'Imagem 3 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo3->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo3);
        
        /*$nome4 = $this->createElement('text', 'nome4', array('label' => 'Nome Imagem 4: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome4);*/
        
        $arquivo4 = $this->createElement('file','imagem4',array('label'=>'Imagem 4 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo4->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo4);
        
        
        
        /*$nome5 = $this->createElement('text', 'nome5', array('label' => 'Nome Imagem 5: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
				        $this->addElement($nome5);*/
        
        $arquivo5 = $this->createElement('file','imagem5',array('label'=>'Imagem 5 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo5->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo5);
        
        
        
        /*$nome6 = $this->createElement('text', 'nome6', array('label' => 'Nome Imagem 6: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome6);*/
        
        $arquivo6 = $this->createElement('file','imagem6',array('label'=>'Imagem 6 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo6->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo6);
        
        
        /*$nome7 = $this->createElement('text', 'nome7', array('label' => 'Nome Imagem 7: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome7);*/
        
        $arquivo7 = $this->createElement('file','imagem7',array('label'=>'Imagem 7 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo7->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo7);
        
        
        /*$nome8 = $this->createElement('text', 'nome8', array('label' => 'Nome Imagem 8: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome8);*/
        
        $arquivo8 = $this->createElement('file','imagem8',array('label'=>'Imagem 8 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo8->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo8);
        
        
        /*$nome9 = $this->createElement('text', 'nome9', array('label' => 'Nome Imagem 9: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome9);*/
        
        $arquivo9 = $this->createElement('file','imagem9',array('label'=>'Imagem 9 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo9->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo9);
        
        
        /*$nome10 = $this->createElement('text', 'nome10', array('label' => 'Nome Imagem 10: '))
				        ->setRequired(false)
				        ->addFilter('StripTags')
				        ->addFilter('stringTrim')
				        ->setAttrib('maxlength', 100)
				        ->setAttrib('class', 'span12');
        $this->addElement($nome10);*/
        
        $arquivo10 = $this->createElement('file','imagem10',array('label'=>'Imagem 10 : ( 640px X 480px ) / Formato: jpg'));
        $arquivo10->setRequired(false)
		        ->addValidator('Count', false, 1)
		        ->addValidator('Size', false, '2mb')
		        ->addValidator('Extension', false, 'jpg');
        $this->addElement($arquivo10);
        
       
        $submit = $this->createElement('submit', 'Gravar')->setAttrib('class','btn btn-primary')->setIgnore(true);

        $this->addElement($submit);
        
        EasyBib_Form_Decorator::setFormDecorator($this,EasyBib_Form_Decorator::BOOTSTRAP, 'Gravar', 'Cancelar');
    }

}
