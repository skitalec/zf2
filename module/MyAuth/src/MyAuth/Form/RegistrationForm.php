<?php
namespace MyAuth\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'usr_name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(),
        ));

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
            'name' => 'usr_password_confirm',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'captcha' => new \Zend\Captcha\Figlet(array(
                    'wordLen' => 3,
                )),
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