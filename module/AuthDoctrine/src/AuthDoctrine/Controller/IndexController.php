<?php

namespace AuthDoctrine\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use MyBlog\Entity\Users;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Controller\BaseController;

class IndexController extends BaseController{

    public function indexAction()
    {
        $entity = $this->getEntityManager();
        $users = $entity->getRepository('MyBlog\Entity\Users')->findAll();
        return array(
            'users' => $users,
        );
    }

}
