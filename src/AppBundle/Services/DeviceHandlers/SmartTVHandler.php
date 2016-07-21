<?php
/**
 * Created with PhpStorm at 19.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Services\DeviceHandlers;

use AppBundle\Entity\Device;
use AppBundle\DeviceHelper\SmartTVInterface;
use AppBundle\Exception\DeviceNotAuthorizedException;


/**
 * Class SmartTVHandler
 *
 * @package AppBundle\Services\DeviceHandlers
 */
class SmartTVHandler
{
    /**
     * @param SmartTVInterface|Device $tv
     * @param string                  $method
     *
     * @throws DeviceNotAuthorizedException
     */
    public function send(SmartTVInterface $tv, string $method)
    {
        if (method_exists($tv, $method)) {
            if (!$tv->isAuthorized()) {
                throw new DeviceNotAuthorizedException;
            }
            /** @var SmartTVInterface $tv */
            $response = $tv->$method();
        }
    }
}
