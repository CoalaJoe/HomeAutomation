<?php
/**
 * Created with PhpStorm at 15.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 *
 * @ORM\Entity()
 *
 * @package AppBundle\Entity
 */
class Settings
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
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Room")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=true)
     */
    private $room;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     *
     * @return $this
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;

        return $this;
    }

}
