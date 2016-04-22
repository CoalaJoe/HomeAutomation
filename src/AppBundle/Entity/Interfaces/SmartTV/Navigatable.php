<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces\SmartTV;


/**
 * Interface Navigatable
 *
 * @package AppBundle\Entity\Interfaces\SmartTV
 */
interface Navigatable
{
    const UP = ['Auf' => 'keyboard_arrow_up'];
    const DOWN = ['Ab' => 'keyboard_arrow_down'];
    const LEFT = ['Links' => 'keyboard_arrow_left'];
    const RIGHT = ['Rechts' => 'keyboard_arrow_right'];

    /**
     * @return mixed
     */
    public function commandUp();

    /**
     * @return mixed
     */
    public function commandDown();

    /**
     * @return mixed
     */
    public function commandLeft();

    /**
     * @return mixed
     */
    public function commandRight();

}