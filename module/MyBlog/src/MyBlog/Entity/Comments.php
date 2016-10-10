<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use MyBlog\Entity\Users;
use Doctrine\ORM\EntityManager;

/**
 * Comments
 * @ORM\Entity
 * @ORM\Table(name="comments")
 * @Annotation\Name("comments")
 */
class Comments
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

    public static function getPostComments(EntityManager $em, $postId){
        $query = $em->createQuery("SELECT p FROM MyBlog\Entity\Comments p WHERE p.postId=".$postId." ORDER BY p.id DESC");
        //$comments = array('id' => array('userId' => '', 'userName' => '', 'postId' => '', 'text' => '', 'created' => ''));
        $comments = [];
        foreach($query->getResult() as $row){
            $id = $row->getId();
            $comments[$id]['userId'] = $row->getUserId();
            $comments[$id]['userName'] = $em->getRepository('MyBlog\Entity\Users')->find($row->getUserId())->getUserFullName();
            $comments[$id]['postId'] = $row->getPostId();
            $comments[$id]['text'] = $row->getText();
            $comments[$id]['created'] = $row->getCreated();
        }
        return $comments;
    }

    public static function addComment(EntityManager $em, $postId, $userId, $data){
        $comment = $em->getRepository('MyBlog\Entity\Comments');
        $em->persist(Comments::prepareData($postId, $userId, $data));
        $em->flush();
    }

    public static function prepareData($postId, $userId, $data){
        $comment = new Comments();
        $comment->setText($data['text']);
        $comment->setUserId($userId);
        $comment->setPostId($postId);
        $comment->setCreated(date("F j, Y, g:i a"));
        return $comment;
    }

}