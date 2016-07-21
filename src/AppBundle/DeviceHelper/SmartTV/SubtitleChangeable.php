<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DeviceHelper\SmartTV;


/**
 * Interface SubtitleChangeable
 *
 * @package AppBundle\DeviceHelper\SmartTV
 */
interface SubtitleChangeable
{
    const SUBTITLE = ['Untertitel' => 'subtitles'];

    /**
     * @return mixed
     */
    public function commandSubtitle();
}
