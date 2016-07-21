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

    /**
     * @return mixed
     */
    public function commandStandBy();
}
