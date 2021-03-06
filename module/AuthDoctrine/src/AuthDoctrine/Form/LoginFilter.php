<?php

namespace AuthDoctrine\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter{

    public function __construct($sm)
    {
        $this->add(array(
            'name' => 'user_name',
            'required' => true,
            'filters' => array(
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
                /*
                array(
                    'name' => 'DoctrineModule\Validator\ObjectExists',
                    'options' => array(
                        'object_repository' => $sm->get('Doctrine\ORM\EntityManager')->getRepository('MyBlog\Entity\Users'),
                        'fields' => 'user_name',
                    ),
                ),
                */
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
                        'min'      => 6,
                        'max'      => 12,
                        'message' => 'Password should be between 6 and 12 characters long!',
                    ),
                ),
            ),
        ));

    }

}