<?php
/**
 * Created with PhpStorm at 21.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;


/**
 * Interface WakeOnLanCapable
 *
 * @package AppBundle\DeviceHelper
 */
interface WakeOnLanCapable
{
    const TURN_ON = ['Einschalten' => 'power_settings_new'];

    /**
     * @return string
     */
    public function getMac():string;

    /**
     * @param string $mac
     *
     * @return mixed
     */
    public function setMac(string $mac);

    /**
     * @return mixed
     */
    public function commandTurnOn();
}
