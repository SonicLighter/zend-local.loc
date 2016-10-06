<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserEditForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('user-edit');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'user_name',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Username (login)',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'user_email',
            'attributes' => array(
                'type'  => 'email',
                'class' => 'form-control',
                'placeholder' => 'Email',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'user_fullname',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'placeholder' => 'Enter full name',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'role',
            'attributes' => array(
                'id' => 'userRole',
                'type'  => 'hidden',
                'class' => 'form-control',
                'placeholder' => 'Enter role',
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
                'value' => 'Update',
                'id' => 'submitbutton',
            ),
        ));

    }
}