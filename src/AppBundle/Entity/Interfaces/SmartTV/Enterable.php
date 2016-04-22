<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces\SmartTV;


/**
 * Interface Enterable
 *
 * @package AppBundle\Entity\Interfaces\SmartTV
 */
interface Enterable
{
    const ENTER = ['Eingeben' => 'panorama_fish_eye'];

    /**
     * @return mixed
     */
    public function commandEnter();
}
