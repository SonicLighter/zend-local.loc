<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\CommentFilter;
use Application\Form\CommentForm;
use Application\Models\AclAccess;
use MyBlog\Entity\Comments;
use MyBlog\Entity\Posts;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyBlog\Entity\Likes;

class IndexController extends BaseController
{
    public function indexAction()
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT p FROM MyBlog\Entity\Posts p ORDER BY p.id DESC');
        $posts = $query->getResult();

        $query = $em->createQuery('SELECT p FROM MyBlog\Entity\Posts p ORDER BY p.id DESC')->setMaxResults(5);
        $top = $query->getResult();

        $posts = $this->generateNewArray($posts);

        return new ViewModel(array(
            'posts' => $posts,
            'top' => $top,
            'acl' => new AclAccess(),
            'popularPosts' => Likes::getPopularPosts($em),
        ));
    }

    public function showAction()
    {

        $em = $this->getEntityManager();
        //$query = $em->createQuery('SELECT p FROM MyBlog\Entity\Posts p ORDER BY p.id DESC');
        //$posts = $query->getResult();
        $posts = $em->getRepository('MyBlog\Entity\Posts')->find($this->params('id'));
        if(!$posts){
            $this->flashMessenger()->addErrorMessage('Not correct post id, please select another one!');
            return $this->redirect()->toRoute('home');
        }

        $posts = $this->getPostsArray($posts);
        $query = $em->createQuery('SELECT p FROM MyBlog\Entity\Posts p ORDER BY p.id DESC')->setMaxResults(5);
        $top = $query->getResult();

        $commentForm = new CommentForm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $commentForm->setData($request->getPost());
            $commentForm->setInputFilter(new CommentFilter($this->getServiceLocator()));
            if($commentForm->isValid()){
                Comments::addComment($em, $this->params('id'), $this->identity()->getId(), $commentForm->getData());
                $commentForm->setData(array('text' => ''));
            }
        }

        //$commentsArray = Comments::getPostComments($em, $this->params('id'));
        return new ViewModel(array(
            'posts' => $posts,
            'top' => $top,
            'acl' => new AclAccess(),
            'likes' => count(Likes::getPostLikes($em, $this->params('id'))),
            'commentForm' => $commentForm,
            'comments' => Comments::getPostComments($em, $this->params('id')),
            'popularPosts' => Likes::getPopularPosts($em),
            //'comments' => (count($commentsArray) > 0)?($commentsArray):(''),
        ));

    }

    public function setLikeAction(){

        Likes::setLike($this->getEntityManager(), $this->identity()->getId(), $this->params('id'));
        echo count(Likes::getPostLikes($this->getEntityManager(), $this->params('id')));
        return $this->getResponse();

    }

    public function getPostsArray($posts){

        $em = $this->getEntityManager();
        $user = $em->getRepository('MyBlog\Entity\Users')->find($posts->getUserId());

        return array('0' => array($user->getUserFullName() => $posts));

    }

    public function generateNewArray($posts){

        $em = $this->getEntityManager();
        $resultArray = [];
        foreach($posts as $post){
            $user = $em->getRepository('MyBlog\Entity\Users')->find($post->getUserId());
            //echo '<br/>'.$post->getUserId();
            $resultArray[count($resultArray)][$user->getUserFullName()] = $post;
        }

        return $resultArray;

    }
}
