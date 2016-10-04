<?php

namespace AuthDoctrine\Form;

use Zend\Form\Form;

class LoginForm extends Form{

    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'user_name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));

        $this->add(array(
            'name' => 'user_password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
            'attributes' => array(
                'type' => 'checkbox',
            ),
            'options' => array(
                'label' => 'Remember me?',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'loginSubmit',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

    }

}