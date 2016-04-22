<?php
/**
 * Created with PhpStorm at 21.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces;


/**
 * Interface WakeOnLanCapable
 *
 * @package AppBundle\Entity\Interfaces
 */
interface WakeOnLanCapable
{
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
}