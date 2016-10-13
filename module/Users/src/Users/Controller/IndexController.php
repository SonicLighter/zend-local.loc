<?php

namespace Users\Controller;

use Admin\Form\UserEditFilter;
use Admin\Form\UserEditForm;
use AuthDoctrine\Form\LoginFilter;
use AuthDoctrine\Form\RegistrationForm;
use DoctrineORMModuleTest\Assets\GraphEntity\User;
use MyBlog\Entity\Online;
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
    public function showAction()
    {
        $user = Users::getUserById($this->getEntityManager(), $this->params('id'));
        if(!$user){
            return $this->redirect()->toRoute('home');
        }
        return array(
            'user' => $user,
            'fullTime' => round(Online::getFullTimeByUserId($this->getEntityManager(), $this->params('id'))[0]->getFullTime()/60/60),
        );
    }
}