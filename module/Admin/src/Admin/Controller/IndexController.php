<?php

namespace Admin\Controller;

use Admin\Form\UserEditFilter;
use Admin\Form\UserEditForm;
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
use Application\Controller\AdminController;
use Application\Models\AclAccess;

class IndexController extends AdminController{

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

    public function userDeleteAction(){

        if($this->params('id') == $this->identity()->getId()){
            $this->flashMessenger()->addErrorMessage('Please select another id, you cant delete user with the same id as yours!');
        }
        else{
            $em = $this->getEntityManager();
            $user = $em->getRepository('MyBlog\Entity\Users')->find($this->params('id'));
            if(!$user){
                $this->flashMessenger()->addErrorMessage('Not correct user id, please select another one!');
            }
            else{
                $em->remove($user);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('User successfully deleted!');
            }
        }

        $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'index'));

    }

    public function userEditAction(){

        $em = $this->getEntityManager();
        $user = $em->getRepository('MyBlog\Entity\Users')->find($this->params('id'));
        if(!$user){
            $this->flashMessenger()->addErrorMessage('Not correct user id, please select another one!');
            return $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'index'));
        }

        $this->flashMessenger()->clearMessages();
        $form = new UserEditForm();
        $em = $this->getEntityManager();

        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setInputFilter(new UserEditFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if($form->isValid()){
                $updateUser = $em->getRepository('MyBlog\Entity\Users')->findBy(array('userName' => $form->getData()['user_name']));
                if(!empty($updateUser) && ($form->getData()['user_name'] != $user->getUserName())){
                    $this->flashMessenger()->addErrorMessage('Such user already exists!');
                }
                else{
                    $em->persist($this->prepareData($user, $form->getData()));
                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('User successfully updated!');
                    $this->redirect()->toRoute('admin/default', array('controller' => 'index', 'action' => 'index'));
                }
            }
        }
        else{
            $form->setData($this->prepareFormData($user));
        }

        return new ViewModel(array(
            'form' => $form,
            'acl' => new AclAccess(),
            'user' => $user,
        ));

    }

    public function prepareFormData(Users $user){

        return array('user_name' => $user->getUserName(), 'user_email' => $user->getUserEmail(), 'user_fullname' => $user->getUserFullName(), 'role' => $user->getUserRole());

    }

    public function prepareData(Users $user, $data){

        $user->setUserName($data['user_name']);
        $user->setUserEmail($data['user_email']);
        $user->setUserFullName($data['user_fullname']);
        $user->setUserRole($data['role']);

        return $user;

    }

}