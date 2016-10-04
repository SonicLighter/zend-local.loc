<?php

namespace MyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

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
}
