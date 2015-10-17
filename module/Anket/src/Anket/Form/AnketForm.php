<?php

namespace Anket\Form;

use Zend\Form\Form;

class AnketForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('anket');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name_anket',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(),
        ));
        $this->add(array(
            'name' => 'phone',
            'type' => 'Text',
            'options' => array(),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'options' => array(),
        ));
        $this->add(array(
            'name' => 'type_equipment',
            'type' => 'Text',
            'options' => array(),
        ));
        $this->add(array(
            'name' => 'comments',
            'type' => 'Textarea',
            'options' => array(),

        ));

        $this->add(array(
            'name' => 'call_back',
            'type' => 'checkbox',
            'options' => array(),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => new \Zend\Captcha\Figlet(array(
                    'wordLen' => 3,
                )),
            ),
        ));

        $this->add(array(
            'name' => 'send_mail',
            'type' => 'checkbox',
            'options' => array(),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

}