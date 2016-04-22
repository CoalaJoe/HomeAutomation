<?php
/**
 * Created with PhpStorm at 20.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Exception;


/**
 * Class DeviceNotAuthorizedException
 *
 * @package AppBundle\Exception
 */
class DeviceNotAuthorizedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Dieses Gerät hat die Heimautomation nicht authorisiert, so dass man es steuern kann.');
    }
}
