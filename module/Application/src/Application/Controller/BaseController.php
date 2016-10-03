<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;

class BaseController extends AbstractActionController{

    protected $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        return parent::onDispatch($e);
    }

    public function setEntityManager(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(){
        return $this->entityManager;
    }

}