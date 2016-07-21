<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper\SmartTV;


/**
 * Interface BackToMenu
 *
 * @package AppBundle\DeviceHelper\SmartTV
 */
interface BackToMenu
{
    const BACK_TO_MENU = ['Menü' => 'menu'];

    /**
     * @return mixed
     */
    public function commandBackToMenu();
}
