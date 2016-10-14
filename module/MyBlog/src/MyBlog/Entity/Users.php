<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\ORM\EntityManager;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="MyBlog\Entity\Repository\UsersRepository")
 * @Annotation\Name("users")
 */
class Users
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
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"text", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Логин:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=300, nullable=false)
     * @Annotation\Attributes({"type":"password", "class":"form-control", "required":"required"})
     * @Annotation\Options({"label":"Пароль:"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=60, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Attributes({"class":"form-control", "required":"required"})
     * @Annotation\Options({"label":"Email:"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
    private $userEmail;


    /**
     * @var string
     *
     * @ORM\Column(name="user_full_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"text", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Полное имя:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $userFullName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_role", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Attributes({"type":"text", "class":"form-control", "required":"required"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"Роль:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":30}})
     */
    private $userRole;

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="string", length=255)
     */
    private $userPicture;

    /**
     * @return string
     */
    public function getUserPicture()
    {
        return $this->userPicture;
    }

    /**
     * @param string $userPicture
     */
    public function setUserPicture($userPicture)
    {
        $this->userPicture = $userPicture;
    }

    /**
     * @return string
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @param string $userRole
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        return $this->userFullName;
    }

    /**
     * @param string $userFullName
     */
    public function setUserFullName($userFullName)
    {
        $this->userFullName = $userFullName;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return Users
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string 
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     * @return Users
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string 
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return Users
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string 
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public static function getUserByLogin(EntityManager $em, $userName)
    {
        return $em->getRepository('MyBlog\Entity\Users')->findBy(array('userName' => $userName));
    }

    public static function vkUserRegistration(EntityManager $em, $data)
    {
        $newUser = new Users();
        $newUser->setUserName($data['uid']);
        $newUser->setUserPassword(hash('sha256', $data['hash']));
        $newUser->setUserEmail('vk'.$data['uid'].'@zend-local.loc');
        $newUser->setUserFullName($data['first_name'].' '.$data['last_name']);
        $newUser->setUserRole('user');
        $newUser->setUserPicture($data['photo']);
        $em->persist($newUser);
        $em->flush();
        return Users::getUserByLogin($em, $data['uid']);
    }

    public static function getUserById(EntityManager $em, $id)
    {
        return $em->getRepository('MyBlog\Entity\Users')->find($id);
    }
}
