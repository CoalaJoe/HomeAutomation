<?php
/**
 * Created with PhpStorm.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper;

/**
 * Class GoBackable
 *
 * @package AppBundle\DeviceHelper
 */
interface GoBackable
{
    const GO_BACK = ['Zurück' => 'arrow_back'];

    /**
     * @return mixed
     */
    public function commandGoBack();
}
