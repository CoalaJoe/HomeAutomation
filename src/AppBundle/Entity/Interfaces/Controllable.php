<?php
/**
 * Created with PhpStorm at 21.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces;


/**
 * Interface Controllable
 *
 * @package AppBundle\Entity\Interfaces
 */
interface Controllable
{
    public function getCommands():array;
}