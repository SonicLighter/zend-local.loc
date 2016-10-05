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

        $form = new RegistrationForm();

        $request = $this->getRequest();
        if($request->isPost()){

            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());

            //$apiService = $this->getServiceLocator()->get('MyBlog\Entity\Users');

            if($form->isValid()){

                $data = $form->getData();
                echo 'Hello';
                die();

            }

        }

        return new ViewModel(array(
            'form' => $form,
        ));

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