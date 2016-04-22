<?php
/**
 * Created with PhpStorm at 17.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


use AppBundle\Entity\Interfaces\DeviceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Device
 *
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "ThermoHumid" = "ThermometerAndHumidityMeter",
 *     "SonyBraTV" = "SonyBraviaSmartTV"
 * })
 *
 * @package AppBundle\Entity
 */
abstract class Device implements DeviceInterface
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
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $apiKey;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $controllable;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Room", inversedBy="devices")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $authorized;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $icon;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    protected $mac;

    /**
     * Device constructor.
     *
     * @param string $ip
     * @param Room   $room
     * @param string $apiKey
     * @param bool   $isControllable
     * @param bool   $isAuthorized
     */
    public function __construct(string $ip, Room $room, string $apiKey = "", bool $isControllable = false, bool $isAuthorized = true)
    {
        $this->ip           = $ip;
        $this->room         = $room;
        $this->apiKey       = $apiKey;
        $this->controllable = $isControllable;
        $this->authorized   = $isAuthorized;
        $this->icon         = $this->icon ? : 'devices';
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isControllable():bool
    {
        return $this->controllable;
    }

    /**
     * @param boolean $controllable
     *
     * @return $this
     */
    public function setControllable(bool $controllable)
    {
        $this->controllable = $controllable;

        return $this;
    }

    /**
     * @return array
     */
    public function getInformations():array
    {
        if (empty($this->apiKey)) {
            $curl = $this->getBaseCurl($this->getIp());
        } else {
            $curl = $this->getBaseCurl($this->getIp().'?apiKey='.$this->getApiKey());
        }

        return $this->getJson($curl);
    }

    /**
     * @param string $url
     *
     * @return resource
     */
    protected function getBaseCurl(string $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 500);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return $curl;
    }

    /**
     * @return string
     */
    public function getIp():string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey():string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param resource $curl
     *
     * @return array
     */
    protected function getJson(resource &$curl):array
    {
        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output);
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
    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return $this->authorized;
    }

    /**
     * @param boolean $authorized
     *
     * @return $this
     */
    public function setAuthorized(bool $authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon():string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }


    /**
     * @return string
     */
    public function getDeviceName()
    {
        return 'Gerät';
    }
}
