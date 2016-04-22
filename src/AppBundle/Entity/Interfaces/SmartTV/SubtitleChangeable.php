<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity\Interfaces\SmartTV;


/**
 * Interface SubtitleChangeable
 *
 * @package AppBundle\Entity\Interfaces\Audio
 */
interface SubtitleChangeable
{
    const SUBTITLE = ['Untertitel' => 'subtitles'];

    /**
     * @return mixed
     */
    public function commandSubtitle();
}