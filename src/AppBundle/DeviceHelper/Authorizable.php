<?php
/**
 * Created with PhpStorm at 20.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;


/**
 * Interface Authorizable
 *
 * @package AppBundle\DeviceHelper
 */
interface Authorizable
{
    public function requestAccess();
    
    public function authenticate($password);
}
