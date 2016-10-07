<?php

namespace Posts\Controller;

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

class IndexController extends PostsBaseController
{

    public function indexAction()
    {

        return new ViewModel();

    }

    public function createPostAction()
    {

        $em = $this->getEntityManager();
        $form = new PostsForm();

        $request = $this->getRequest();
        if($request->isPost()){

            $form->setInputFilter(new PostsFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if($form->isValid()){

                $post = $this->prepareData($form->getData());
                $em->persist($post);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Post successfully created!');
                return $this->redirect()->toRoute('home');

            }

        }

        return new ViewModel(array(
            'form' => $form,
        ));

    }

    public function postDeleteAction(){

        $em = $this->getEntityManager();
        $post = $em->getRepository('MyBlog\Entity\Posts')->find($this->params('id'));
        if(!$post){
            $this->flashMessenger()->addErrorMessage('Not correct post id, please select another one!');
        }
        else{
            $em->remove($post);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Post successfully deleted!');
        }

        return $this->redirect()->toRoute('home');

    }

    public function postEditAction(){

        $em = $this->getEntityManager();
        $post = $em->getRepository('MyBlog\Entity\Posts')->find($this->params('id'));
        if(!$post){
            $this->flashMessenger()->addErrorMessage('Not correct post id, please select another one!');
            return $this->redirect()->toRoute('home');
        }

        $this->flashMessenger()->clearMessages();
        $form = new PostsForm();

        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setInputFilter(new PostsFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if($form->isValid()){

                $em->persist($this->prepareEditData($post, $form->getData()));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Post ('.$form->getData()['title'].') successfully updated!');
                $this->redirect()->toRoute('home');

            }
        }
        else{
            $form->setData($this->prepareFormData($post));
        }

        return new ViewModel(array(
            'form' => $form,
        ));

    }

    public function prepareFormData(Posts $post){

        return array('title' => $post->getTitle(), 'text' => $post->getText());

    }

    public function prepareEditData(Posts $post, $data){

        $post->setTitle($data['title']);
        $post->setText($data['text']);

        return $post;

    }

    public function prepareData($data){

        $post = new Posts();
        $post->setUserId($this->identity()->getId());
        $post->setTitle($data['title']);
        $post->setText($data['text']);
        $post->setCreated(date("F j, Y, g:i a"));

        return $post;

    }

}