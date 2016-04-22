<?php
/**
 * Created with PhpStorm at 17.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Services;


use AppBundle\Entity\Device;
use AppBundle\Entity\Interfaces\SmartTVInterface;
use AppBundle\Services\DeviceHandlers\SmartTVHandler;

/**
 * Class DevicesManager
 *
 * @package AppBundle\Services
 */
class DevicesManager
{
    /** @var  SmartTVHandler */
    private $smartTVHandler;

    /**
     * DevicesManager constructor.
     *
     * @param SmartTVHandler $smartTVHandler
     */
    public function __construct(SmartTVHandler $smartTVHandler)
    {
        $this->smartTVHandler = $smartTVHandler;
    }

    /**
     * @param Device $device
     * @param string $method
     */
    public function send(Device $device, string $method)
    {
        if ($device instanceof SmartTVInterface) {
            $this->smartTVHandler->send($device, $method);
        }
    }
}
