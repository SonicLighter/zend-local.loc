<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Zend\Form\Annotation;
use MyBlog\Entity\Users;

/**
 * Posts
 * @ORM\Entity
 * @ORM\Table(name="posts")
 * @Annotation\Name("posts")
 */
class Posts
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="string", length=255, nullable=false)
     */
    private $created;

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public static function getPostById(EntityManager $em, $postId)
    {
        return $em->getRepository('MyBlog\Entity\Posts')->find($postId);
    }

    public static function addPost(EntityManager $em, $userId, $data)
    {
        $post = new Posts();
        $post->setUserId($userId);
        $post->setTitle($data['title']);
        $post->setText($data['text']);
        $post->setCreated(date("F j, Y, g:i a"));
        $em->persist($post);
        $em->flush();
        $query = $em->createQuery("SELECT p FROM MyBlog\Entity\Posts p ORDER BY p.id DESC");
        $posts = $query->getResult();
        return $posts[0]->getId();
    }

    public static function updatePost(EntityManager $em, $postId, $data)
    {
        $post = Posts::getPostById($postId);
        $post->setTitle($data['title']);
        $post->setText($data['text']);
        $em->persist($post);
        $em->flush();
    }

}