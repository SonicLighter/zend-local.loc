<?php

namespace AuthDoctrine\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter
{
    public function __construct($sm)
    {

        $this->add(array(
            'name'     => 'user_name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 20,
                        'message' => 'Username should be between 3 and 20 characters long!',
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name'       => 'user_email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'user_password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 6,
                        'max'      => 12,
                        'message' => 'Password should be between 6 and 12 characters long!',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'user_fullname',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 20,
                        'message' => 'Username should be between 3 and 20 characters long!',
                    ),
                ),
            ),
        ));

        /*
        $this->add(array(
            'name'     => 'usrPasswordConfirm',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min'      => 6,
                        'max'      => 12,
                    ),
                ),
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'usrPassword',
                    ),
                ),
            ),
        ));
        */
    }
}