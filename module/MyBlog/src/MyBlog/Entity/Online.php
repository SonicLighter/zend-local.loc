<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use MyBlog\Entity\Users;
use Doctrine\ORM\EntityManager;

/**
 * Online
 * @ORM\Entity
 * @ORM\Table(name="online")
 * @Annotation\Name("online")
 */
class Online
{

    const ONLINE_LIMIT = 15;

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
     * @ORM\Column(name="time", type="string", length=255, nullable=false)
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="fullTime", type="string", length=255, nullable=false)
     */
    private $fullTime;

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
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getFullTime()
    {
        return $this->fullTime;
    }

    /**
     * @param string $fullTime
     */
    public function setFullTime($fullTime)
    {
        $this->fullTime = $fullTime;
    }

    public static function setCurrenTime(EntityManager $em, $userId)
    {
        $user = $em->getRepository('MyBlog\Entity\Online')->findBy(array('userId' => $userId));
        if(!$user){
            $user = new Online();
            $user->setUserId($userId);
            $user->setTime(time());
            $user->setFullTime('0');
            $em->persist($user);
        }
        else{
            $em->persist(Online::prepareNewTime($user[0]));
        }

        $em->flush();
    }

    public static function prepareNewTime(Online $user)
    {
        $prevTime = $user->getTime();
        $fullTime = $user->getFullTime();
        if(((time()/60) - ($prevTime/60)) > self::ONLINE_LIMIT){
            $fullTime = $fullTime + self::ONLINE_LIMIT*60;
        } else{
            $fullTime = $fullTime + (time() - $prevTime);
        }

        $user->setTime(time());
        $user->setFullTime($fullTime);
        return $user;
    }

    public static function getOnline(EntityManager $em)
    {
        $online = $em->getRepository('MyBlog\Entity\Online')->findAll();
        $usersOnline = [];
        foreach($online as $id => $userOnline){
            if(((time()/60) - ($userOnline->getTime()/60)) < self::ONLINE_LIMIT){
                $usersOnline[$id]['userId'] = $userOnline->getUserId();
                $usersOnline[$id]['userName'] = $em->getRepository('MyBlog\Entity\Users')->find($userOnline->getUserId())->getUserFullName();
                $usersOnline[$id]['fullTime'] = round($userOnline->getFullTime()/60/60, 1);
            }
        }
        return $usersOnline;
    }

    public static function getFullTimeByUserId(EntityManager $em, $userId)
    {
        return $em->getRepository('MyBlog\Entity\Online')->findBy(array('userId' => $userId));
    }

}