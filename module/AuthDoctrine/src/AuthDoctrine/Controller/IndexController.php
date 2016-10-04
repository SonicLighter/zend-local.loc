<?php

namespace AuthDoctrine\Controller;

use AuthDoctrine\Form\LoginFilter;
use Zend\Mvc\Controller\AbstractActionController;
use MyBlog\Entity\Users;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use AuthDoctrine\Form\LoginForm;

class IndexController extends BaseController{

    public function indexAction()
    {

        $em = $this->getEntityManager();

        $users = $em->getRepository('MyBlog\Entity\Users')->findAll();
        $message = $this->params()->fromQuery('message', 'foo');

        return new ViewModel(
            array(
                'message' => $message,
                'users' => $users,
            )
        );

    }

    public function loginAction(){

        $form = new LoginForm();
        //$form->get('submit')->setValue('Login');
        $messages = null;

        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if($form->isValid()){
                $data = $form->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['user_name']);
                $adapter->setCredentialValue($data['user_password']);
                $authResult = $authService->authenticate();
                if($authResult->isValid()){
                    $identity = $authResult->getIdentity();
                    $authService->getStorage()->write($identity);
                    $time = 1209600; // 2 weeks
                    if($data['rememberme']){
                        $sessionManager = new \Zend\Session\SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                }
                foreach($authResult->getMessages() as $message){
                    $messages .= $message."\n";
                }
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'messages' => $messages,
        ));

    }

    /*
    public function getUserForm(Users $user){

        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm('\MyBlog\Entity\Users');
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(),'\Users'));
        $form->bind($user);

        return $form;

    }

    public function getLoginForm(Users $user){

        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/auth-doctrine/index/login/');
        $form->setValidationGroup('user_name', 'user_password');

        return $form;

    }

    public function loginAction(){

        $em = $this->getEntityManager();
        $user = new Users();
        $form = $this->getLoginForm($user);

        $messages = null;
        $request = $this->getRequest();

        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $user = $form->getData();
                $authResult = $em->getRepository('MyBlog\Entity\Users')->login($user, $this->getServiceLocator());
                if($authResult->getCode() != \Zend\Authentication\Result::SUCCESS){
                    foreach($authResult->getMessages() as $message){
                        $messages .= "$message\n";
                    }
                }
                else{
                    return array(

                    );
                }
            }
        }

        return array(
            'form' => $form,
            'messages' => $messages,
        );

    }

    public function indexAction()
    {
        $entity = $this->getEntityManager();
        $users = $entity->getRepository('MyBlog\Entity\Users')->findAll();
        return array(
            'users' => $users,
        );
    }
    */

}
