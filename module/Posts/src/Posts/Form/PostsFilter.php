<?php

namespace Posts\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PostsFilter extends InputFilter
{
    public function __construct($sm)
    {

        $this->add(array(
            'name'     => 'title',
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
                        'max' => 100,
                        'message' => 'Title should be between 3 and 100 characters long!',
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name'     => 'text',
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
                        'message' => 'Text should be greater then 3 characters long!',
                    ),
                ),
            ),
        ));

    }
}