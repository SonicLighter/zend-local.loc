<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;
use Application\Models\AclAccess;

class PostsBaseController extends BaseController{

    protected $entityManager;

    public function onDispatch(MvcEvent $e)
    {
        $acl = new AclAccess();

        if(!$this->identity()){
            return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
        }
        else if(!$acl->isAllowed($this->identity()->getUserRole(), $acl::NEWS)){
            return $this->redirect()->toRoute('home');
        }

        return parent::onDispatch($e);

    }

}