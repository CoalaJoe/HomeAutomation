<?php
/**
 * Created with PhpStorm at 17.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;


/**
 * Interface DeviceInterface
 *
 * @package AppBundle\DeviceHelper
 */
interface DeviceInterface
{
    /**
     * Returns information of the device.
     * 
     * @return array
     */
    public function getInformations():array;

}
