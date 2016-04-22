<?php
/**
 * Created with PhpStorm at 17.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces;


/**
 * Interface DeviceInterface
 *
 * @package AppBundle\Entity\Interfaces
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
