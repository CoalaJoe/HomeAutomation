<?php
/**
 * Created with PhpStorm at 22.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


/**
 * Class WakeOnLanTrait
 *
 * @package AppBundle\Entity
 */
trait WakeOnLanTrait
{
    /**
     * Turns on WOL-Device
     */
    public function commandTurnOn()
    {
        $mac_array = explode(':', $this->getMac());

        $hwaddr = '';

        foreach($mac_array AS $octet)
        {
            $hwaddr .= chr(hexdec($octet));
        }

        // Create Magic Packet

        $packet = '';
        for ($i = 1; $i <= 6; $i++)
        {
            $packet .= chr(255);
        }

        for ($i = 1; $i <= 16; $i++)
        {
            $packet .= $hwaddr;
        }

        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if ($sock)
        {
            $options = socket_set_option($sock, 1, 6, true);

            if ($options >=0)
            {
                socket_sendto($sock, $packet, strlen($packet), 0, '255.255.255.0', 7);
                socket_close($sock);
            }
        }
    }
}
