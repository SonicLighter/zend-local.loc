<?php

namespace Application\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class CommentFilter extends InputFilter
{
    public function __construct($sm)
    {

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
                        'max' => 500,
                        'message' => 'Text should be greater then 3 characters long!',
                    ),
                ),
            ),
        ));

    }
}