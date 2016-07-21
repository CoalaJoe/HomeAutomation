<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper\Audio;


/**
 * Interface VolumeChangeable
 *
 * @package AppBundle\DeviceHelper\Audio
 */
interface VolumeChangeable
{

    const VOLUME_UP   = ['Volume +' => 'volume_up'];
    const VOLUME_DOWN = ['Volume -' => 'volume_down'];

    /**
     * @return mixed
     */
    public function commandVolumeUp();

    /**
     * @return mixed
     */
    public function commandVolumeDown();
}
