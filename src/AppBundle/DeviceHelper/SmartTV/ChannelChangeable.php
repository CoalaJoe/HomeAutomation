<?php
/**
 * Created with PhpStorm at 19.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper\SmartTV;


/**
 * Interface ChannelChangeable
 *
 * @package AppBundle\DeviceHelper\SmartTV
 */
interface ChannelChangeable
{
    const CHANNEL_UP       = ['Kanal +' => 'arrow_drop_up'];
    const CHANNEL_DOWN     = ['Kanal -' => 'arrow_drop_down'];
    const CHANNEL_PREVIOUS = ['Vorher. Kanal' => 'crop_din'];

    /**
     * @return mixed
     */
    public function commandChannelUp();

    /**
     * @return mixed
     */
    public function commandChannelDown();

    /**
     * @return mixed
     */
    public function commandChannelPrevious();
}
