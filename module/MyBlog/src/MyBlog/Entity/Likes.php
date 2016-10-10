<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use MyBlog\Entity\Users;
use Doctrine\ORM\EntityManager;

/**
 * Likes
 * @ORM\Entity
 * @ORM\Table(name="likes")
 * @Annotation\Name("likes")
 */
class Likes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="postId", type="integer", nullable=false)
     */
    private $postId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public static function getPostLikes(EntityManager $em, $postId)
    {
        $query = $em->createQuery("SELECT p FROM MyBlog\Entity\Likes p WHERE p.postId=".$postId);
        return $query->getResult();
    }

    public static function setLike(EntityManager $em, $userId, $postId){
        $like = $em->getRepository('MyBlog\Entity\Likes')->findBy(array('userId' => $userId, 'postId' => $postId));
        if(!$like){
            $newLike = new Likes();
            $newLike->setUserId($userId);
            $newLike->setPostId($postId);
            $em->persist($newLike);
            $em->flush();
        }
    }

    public static function getPopularPosts(EntityManager $em){
        //$query = $em->createQuery("SELECT p, COUNT(p) FROM MyBlog\Entity\Likes p WHERE p.postId=".$postId);
        $query = $em->createQuery("SELECT COUNT(p) as likes, p.postId FROM MyBlog\Entity\Likes p WHERE p.postId in (SELECT pl.postId FROM MyBlog\Entity\Likes pl) GROUP BY p.postId ORDER BY likes DESC")->setMaxResults(5);
        $topPopularNews = [];
        $posts = $em->getRepository('MyBlog\Entity\Posts');
        foreach($query->getResult() as $id => $post){
            $topPopularNews[$id]['id'] = $post['postId'];
            $topPopularNews[$id]['title'] = $posts->find($post['postId'])->getTitle();
            $topPopularNews[$id]['text'] = substr($posts->find($post['postId'])->getText(), 0, 150).'..';
            $topPopularNews[$id]['created'] = $posts->find($post['postId'])->getCreated();
            $topPopularNews[$id]['likes'] = $post['likes'];
        }
        return $topPopularNews;
    }

}