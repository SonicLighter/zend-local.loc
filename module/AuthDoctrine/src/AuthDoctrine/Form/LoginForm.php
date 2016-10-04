<?php

namespace AuthDoctrine\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form{

    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'user_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'Username',
                'id' => 'inputLogin',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'name' => 'user_password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'rememberme',
            'options' => array(
                'label' => '',
                'use_hidden_element' => true,
                'checked_value' => 'good',
                'unchecked_value' => 'bad'
            )
        ));

        /*
        $this->add(array(
            'name' => 'rememberme',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Checkbox',
            ),
            'options' => array(
                'label' => 'Remember me?',
            ),
        ));
        */

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'loginSubmit',
                'class' => 'btn btn-default',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

    }

}