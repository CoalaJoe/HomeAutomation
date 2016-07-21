<?php
/**
 * Created with PhpStorm at 19.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;


/**
 * Interface SmartTVInterface
 *
 * @package AppBundle\DeviceHelper
 */
interface SmartTVInterface extends Controllable
{
    /**
     * @return array
     */
    public function getInputs():array;
}
