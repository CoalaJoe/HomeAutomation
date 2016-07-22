<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;


/**
 * Interface StandByChangeable
 *
 * @package AppBundle\DeviceHelper
 */
interface StandByChangeable
{
    const STAND_BY = ['Standby' => 'power_settings_new'];

    const STATUS_ON = 1;

    const STATUS_OFF = 0;

    const STATUS_STANDBY = 2;

    /**
     * @return mixed
     */
    public function commandStandBy();

    /**
     * @return int
     */
    public function getPowerStatus();
}
