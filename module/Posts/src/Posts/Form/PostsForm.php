<?php

namespace Posts\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PostsForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('create-post');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Title',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\Textarea',
                'class' => 'form-control',
                'placeholder' => 'Put post content here...',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-default',
                'value' => 'Send',
                'id' => 'submitbutton',
            ),
        ));

    }
}