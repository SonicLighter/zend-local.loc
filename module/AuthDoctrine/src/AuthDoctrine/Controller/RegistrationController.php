<?php

namespace AuthDoctrine\Controller;

use Application\Controller\BaseController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyBlog\Entity\Users;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element;
use AuthDoctrine\Form\RegistrationForm;
use AuthDoctrine\Form\RegistrationFilter;
use Zend\Mail\Message;
use AuthDoctrine\Service\IsExistValidator;

class RegistrationController extends BaseController
{

    public function indexAction()
    {

        $this->flashMessenger()->clearMessages();
        //$message = null;
        $form = new RegistrationForm();
        $em = $this->getEntityManager();

        $request = $this->getRequest();
        if($request->isPost()){

            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());

            $apiService = $this->getServiceLocator()->get('AuthDoctrine\Service\IsExistValidator');

            if($form->isValid()){
                $user = $this->prepareData($form->getData());
                if($apiService->exists($user->getUserName(), array('userName'))){
                    //$message = 'User with such username already exists!';
                    $this->flashMessenger()->addErrorMessage('User with such username already exists!');
                }
                else{
                    $em->persist($user);
                    $em->flush();
                    return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
                }

                /*
                echo 'hsad';
                die();
                */
            }

        }

        return new ViewModel(array(
            'form' => $form,
            //'message' => $message,
        ));

    }

    public function prepareData($data){

        $user = new Users();
        $user->setUserName($data['user_name']);
        $user->setUserPassword(hash('sha256', $data['user_password']));
        $user->setUserEmail($data['user_email']);
        $user->setUserFullName($data['user_fullname']);
        $user->setUserRole('user');

        return $user;

    }

    /*
    public function indexAction()
    {
        $entityManager = $this->getEntityManager();
        $user = new Users;
        $form = new RegistrationForm();
        //$form->get('submit')->setValue('Register');
        $form->setHydrator(new DoctrineHydrator($entityManager,'MyBlog\Entity\Users'));
        $form->bind($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->prepareData($user);
                $this->sendConfirmationEmail($user);
                $this->flashMessenger()->addMessage($user->getUserEmail());
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirect()->toRoute('auth-doctrine/default', array('controller'=>'index', 'action'=>'login'));
            }
        }
        return new ViewModel(array(
            'form' => $form
        ));
        //return new ViewModel();
    }
    */
}