<?php
/**
 * Created with PhpStorm at 15.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Room
 *
 * @ORM\Entity()
 *
 * @package AppBundle\Entity
 */
class Room implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Level
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Level", inversedBy="rooms")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $level;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Device", mappedBy="room")
     */
    private $devices;

    /**
     * Room constructor.
     *
     * @param string|null $name
     * @param Level|int   $level
     */
    public function __construct(string $name = null, Level $level = null)
    {
        $this->devices = new ArrayCollection();
        $this->name    = $name;
        $this->level   = $level;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Level|int
     */
    public function getLevel():Level
    {
        return $this->level;
    }

    /**
     * @param Level|int $level
     *
     * @return $this
     */
    public function setLevel(Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param ArrayCollection $devices
     *
     * @return $this
     */
    public function setDevices(ArrayCollection $devices)
    {
        $this->devices = $devices;

        return $this;
    }

    /**
     * @param Device $device
     *
     * @return $this
     */
    public function addDevice(Device $device)
    {
        $this->devices->add($device);

        return $this;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'level' => $this->level
        ];
    }
}
