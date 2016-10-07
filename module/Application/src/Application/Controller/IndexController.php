<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Models\AclAccess;
use MyBlog\Entity\Posts;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

        return new ViewModel(array(
            'posts' => $posts,
            'top' => $top,
            'acl' => new AclAccess(),
        ));
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
