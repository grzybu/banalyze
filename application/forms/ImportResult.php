<?php

class Application_Form_ImportResult extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

        $file_element = new Zend_Form_Element_File('image_file');
        $file_element->setLabel('Skan wyników');
        $file_element->setDestination(DATA_PATH . '/images/');
        $file_element->addValidator('Count', false, 1);
        $this->addElement($file_element);

        $this->addElement('submit', 'Wyślij');

    }


}

