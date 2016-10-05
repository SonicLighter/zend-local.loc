<?php

namespace AuthDoctrine\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {

        parent::__construct('registration');

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
            'name' => 'user_password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password',
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
                'placeholder' => 'Enter your full name',
            ),
            'options' => array(
                'label' => '',
            ),
        ));

        /*
        $this->add(array(
            'name' => 'usrPasswordConfirm',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Confirm Password',
            ),
        ));
        */

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => new \Zend\Captcha\Figlet(),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-default',
                'value' => 'Register',
                'id' => 'submitbutton',
            ),
        ));

    }
}