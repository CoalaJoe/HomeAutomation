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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mac;
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
     * @return string
     */
    public function getMac()
    {
        return $this->mac;
    }

    /**
     * @param string $mac
     *
     * @return $this
     */
    public function setMac(string $mac)
    {
        $mac = str_replace('-', ':', $mac);
        $mac = str_replace('.', ':', $mac);
        if (strlen($mac) !== 17) {
            $mac = str_replace(':', '', $mac);
            $mac = substr_replace($mac, ':', 2, 0);
            $mac = substr_replace($mac, ':', 5, 0);
            $mac = substr_replace($mac, ':', 8, 0);
            $mac = substr_replace($mac, ':', 11, 0);
            $mac = substr_replace($mac, ':', 14, 0);
        }
        $this->mac = $mac;

        return $this;
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
     * @return object
     */
    protected function getJson(&$curl)
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

    /**
     * @return string
     */
    public function getTemplate()
    {
        return "default";
    }

    /**
     * @param null $interfaces
     *
     * @return array
     */
    public function getCommands($interfaces = null):array
    {
        if (!$interfaces) {
            $interfaces = class_implements(__CLASS__);
        }
        if (!is_array($interfaces)) {
            $interfaces = [$interfaces];
        }
        $methods = [];
        foreach ($interfaces as $interface) {
            foreach (get_class_methods($interface) as $method) {
                if (substr($method, 0, 7) === 'command') {
                    $methods[$interface][] = $method;
                }
            }
        }

        $commands = [];
        foreach ($methods as $interfaceName => $interface) {
            foreach ($interface as $method) {
                $constName    = substr($method, 7);
                $constName[0] = strtolower($constName[0]);
                $func         = create_function('$c', 'return "_" . strtolower($c[1]);');
                $constName    = strtoupper(preg_replace_callback('/([A-Z])/', $func, $constName));

                $rc    = new \ReflectionClass($interfaceName);
                $const = $rc->getConstant($constName);
                reset($const);

                $commands[key($const)] = [
                    reset($const) => $method
                ];
            }
        }

        return $commands;
    }

    /**
     * @return null
     */
    public function getTemplateCommands()
    {
        return null;
    }
}
