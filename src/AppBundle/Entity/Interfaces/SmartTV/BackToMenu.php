<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces\SmartTV;


/**
 * Interface BackToMenu
 *
 * @package AppBundle\Entity\Interfaces\SmartTV
 */
interface BackToMenu
{
    const BACK_TO_MENU = ['Menü' => 'menu'];

    /**
     * @return mixed
     */
    public function commandBackToMenu();
}