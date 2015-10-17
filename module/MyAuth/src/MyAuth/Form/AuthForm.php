<?php

namespace MyAuth\Form;

use Zend\Form\Form;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('auth');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'usr_email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(),
        ));

        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(),
        ));

        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Remember Me?',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}