<?php
namespace MyAuth\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Auth implements InputFilterAwareInterface
{
    public $usr_id;
    public $usr_name;
    public $usr_password;
    public $usr_password_salt;
    public $usr_email;
    public $usr_email_confirmed;
    public $usr_active;
    public $usr_registration_token;


    public function exchangeArray($data)
    {
        $this->usr_id = (!empty($data['usr_id'])) ? $data['usr_id'] : null;
        $this->usr_name = (!empty($data['usr_name'])) ? $data['usr_name'] : null;
        $this->usr_password = (!empty($data['usr_password'])) ? $data['usr_password'] : null;
        $this->usr_password_salt = (!empty($data['usr_password_salt'])) ? $data['usr_password_salt'] : null;
        $this->usr_email = (!empty($data['usr_email'])) ? $data['usr_email'] : null;
        $this->usr_email_confirmed = (isset($data['usr_email_confirmed'])) ? $data['usr_email_confirmed'] : null;
        $this->usr_active = (isset($data['usr_active'])) ? $data['usr_active'] : null;
        $this->usr_registration_token = (!empty($data['usr_registration_token'])) ? $data['usr_registration_token'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'usr_email',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'usr_password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}