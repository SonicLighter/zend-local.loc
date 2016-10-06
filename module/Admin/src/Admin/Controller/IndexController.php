<?php

namespace Admin\Controller;

use AuthDoctrine\Form\LoginFilter;
use AuthDoctrine\Form\RegistrationForm;
use DoctrineORMModuleTest\Assets\GraphEntity\User;
use Zend\Mvc\Controller\AbstractActionController;
use MyBlog\Entity\Users;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use AuthDoctrine\Form\LoginForm;
use Zend\Session\SessionManager;
use AuthDoctrine\Form\RegistrationFilter;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

class IndexController extends BaseController{

    public function indexAction()
    {
        $em = $this->getEntityManager();

        //$users = $em->getRepository('MyBlog\Entity\Users')->findAll();
        //$message = $this->params()->fromQuery('message', 'foo');

        $query = $em->createQuery('SELECT u FROM MyBlog\Entity\Users u ORDER BY u.id DESC');
        $users = $query->getResult();

        return new ViewModel(array(
                //'message' => $message,
                'users' => $users,
        ));
    }

}