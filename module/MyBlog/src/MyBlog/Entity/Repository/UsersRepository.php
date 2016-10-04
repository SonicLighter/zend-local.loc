<?php

namespace MyBlog\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use MyBlog\Entity\Users;

class UsersRepository extends EntityRepository{

    public function login(Users $user, $sm){

        $authService = $sm->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->getIdentityValue($user->getUserName());
        $adapter->setCredentialValue($user->getUserPassword());
        $authResult = $authService->authenticate();
        $identity = null;

        if($authResult->isValid()){
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }

        return $authResult;

    }

}