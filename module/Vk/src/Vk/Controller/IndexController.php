<?php

namespace Vk\Controller;

use Admin\Form\UserEditFilter;
use Admin\Form\UserEditForm;
use AuthDoctrine\Form\LoginFilter;
use AuthDoctrine\Form\RegistrationForm;
use DoctrineORMModuleTest\Assets\GraphEntity\User;
use MyBlog\Entity\Posts;
use Posts\Form\PostsFilter;
use Posts\Form\PostsForm;
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
use Application\Controller\PostsBaseController;
use Application\Models\AclAccess;

class IndexController extends BaseController
{

    public function indexAction()
    {

        return new ViewModel();

    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $getParams = $request->getQuery();
        print_r($getParams);
        // return $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'index'));
        return $this->getResponse();
    }

}