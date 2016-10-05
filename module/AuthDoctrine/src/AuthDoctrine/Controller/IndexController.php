<?php

namespace AuthDoctrine\Controller;

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

    const SESSION_TIME = 1209600;

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

    // now registration in RegistrationController
    public function registerAction(){

        $form = new RegistrationForm();

        $request = $this->getRequest();
        if($request->isPost()){

            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());

            $apiService = $this->getServiceLocator()->get('AuthDoctrine\Service\IsExistValidator');

            if($form->isValid()){

                $data = $form->getData();
                echo 'hello';
                die();

            }

        }

        return new ViewModel(array(
            'form' => $form,
        ));

        /*
        $em = $this->getEntityManager();

        $user = new Users();
        $form = new RegistrationForm();
        $form->setHydrator(new DoctrineHydrator($em, 'MyBlog\Entity\Users'));
        $form->bind($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->prepareData($user);
                //$this->sendConfirmationEmail($user);
                //$this->flashMessenger()->addMessage($user->getUsrEmail());
                $em->persist($user);
                $em->flush();
                return $this->redirect()->toRoute('auth-doctrine/default', array('controller'=>'index', 'action'=>'login'));
            }
        }
        return new ViewModel(array('form' => $form));
        */

    }

    public function prepareData($user)
    {
        $user->setUserPassword($user->getUserPassword());
        //$user->setUsrlId(2);
        //$user->setLngId(1);
        //$user->setUsrRegistrationDate(new \DateTime());
        //$user->setUsrRegistrationToken(md5(uniqid(mt_rand(), true))); // $this->generateDynamicSalt();
//		$user->setUsrRegistrationToken(uniqid(php_uname('n'), true));
        //$user->setUsrEmailConfirmed(0);
        return $user;
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
                    $time = self::SESSION_TIME; // 2 weeks
                    if($data['rememberme']){
                        $sessionManager = new \Zend\Session\SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                    return $this->redirect()->toRoute('home');
                }
                /*
                foreach($authResult->getMessages() as $message){
                    $messages .= $message."\n";
                }
                */
                $messages = 'Incorrect username or password!';
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'messages' => $messages,
        ));

    }

    public function logoutAction(){

        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        $sessionManager = new SessionManager();
        $sessionManager->forgetMe();

        return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));

    }

}
