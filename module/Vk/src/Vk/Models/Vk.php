<?php

namespace Vk\Models;

use Doctrine\ORM\EntityManager;
use MyBlog\Entity\Users;

class Vk
{

    private $data;
    private $em;

    public function __construct($em, $data)
    {
        $this->data = $data;
        $this->em = $em;
    }

    public function login($serviceLocator)
    {
        $user = Users::getUserByLogin($this->em, $this->data['uid']);
        if(!$user){
            $user = $this->registration();
        }
        $authService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($user[0]->getUserName());
        $adapter->setCredentialValue($this->data['hash']);
        $authResult = $authService->authenticate();
        if($authResult->isValid()){
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
            return true;
        }
        return false;
    }

    public function registration()
    {
        return Users::vkUserRegistration($this->em, $this->data);
    }

}