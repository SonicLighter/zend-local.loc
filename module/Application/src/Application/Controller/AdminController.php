<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;

class AdminController extends BaseController{

    protected $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        if(!$this->identity()){
            return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
        }
        return parent::onDispatch($e);
    }

}