<?php

namespace Admin\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class UserEditFilter extends InputFilter
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
    }
}