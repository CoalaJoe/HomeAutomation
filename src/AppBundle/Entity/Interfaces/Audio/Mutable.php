<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces\Audio;


/**
 * Interface Mutable
 *
 * @package AppBundle\Entity\Interfaces\Audio
 */
interface Mutable
{

    const MUTE = ['Stumm' => 'volume_off'];

    /**
     * @return mixed
     */
    public function commandMute();

}