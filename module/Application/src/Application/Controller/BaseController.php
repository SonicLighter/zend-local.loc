<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;
use MyBlog\Entity\Online;

class BaseController extends AbstractActionController{

    protected $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        if($this->identity()){
            Online::setCurrenTime($this->entityManager, $this->identity()->getId());
        }
        return parent::onDispatch($e);
    }

    public function setEntityManager(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(){
        return $this->entityManager;
    }

}