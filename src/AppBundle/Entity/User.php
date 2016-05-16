<?php
/**
 * Created with PhpStorm at 13.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @ORM\Table(name="app_user")
 * @ORM\Entity()
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 *
 * @package AppBundle\Entity
 */
class User implements AdvancedUserInterface, \Serializable
{
    const TYPE_ADMIN    = 1;
    const TYPE_FAMILY   = 2;
    const TYPE_VISITORS = 3;
    const TYPE_DEMO     = 4;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
     * @var string
     *
     * @Assert\Email()
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Settings", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="settings_id", referencedColumnName="id")
     *
     * @var Settings
     */
    private $settings;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->active    = true;
        $this->createdAt = new \DateTime();
        $this->settings  = new Settings();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User $this
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return User $this
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return User $this
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive():bool
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     *
     * @return $this
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt():\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Settings
     */
    public function getSettings():Settings
    {
        return $this->settings;
    }
    
    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType($type)
    {
        if (in_array($type, $this->getTypes())) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getTypes():array
    {
        $rc        = new \ReflectionClass(__CLASS__);
        $constants = $rc->getConstants();
        $types     = [];
        foreach ($constants as $name => $constant) {
            if (substr($name, 0, 5) === 'TYPE_') {
                $types[substr($name, 5)] = $constant;
            }
        }

        return $types;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        switch ($this->type) {
            case self::TYPE_ADMIN:

                return ['ROLE_ADMIN'];
            case self::TYPE_FAMILY:

                return ['ROLE_FAMILY'];
            case self::TYPE_VISITORS:

                return ['ROLE_VISITORS'];
            case self::TYPE_DEMO:

                return ['ROLE_DEMO'];
            default:
                break;
        }

        return ['ROLE_USER'];
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return null
     */
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        if (self::TYPE_ADMIN === $this->type) {

            return true;
        } else if (self::TYPE_FAMILY === $this->type) {

            return true;
        } else if (self::TYPE_VISITORS === $this->type) {
            $datetime = new \DateTime(date('Y-m-d H:i:s', strtotime("-1 day")));

            return ($datetime > $this->createdAt) ? false : true;
        } else if (self::TYPE_DEMO === $this->type) {
            $datetime = new \DateTime(date('Y-m-d H:i:s', strtotime("-1 hour")));

            return ($datetime > $this->createdAt) ? false : true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isEnabled():bool
    {
        return $this->active;
    }

    /** @see \Serializable::serialize() */
    public function serialize():string
    {
        return serialize([
                $this->id,
                $this->username,
                $this->password,
                $this->firstname,
                $this->lastname,
                $this->email,
                $this->active
            ]
        );
    }

    /** @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list ($this->id, $this->username, $this->password, $this->firstname, $this->lastname, $this->email, $this->active) = unserialize($serialized);
    }

}
