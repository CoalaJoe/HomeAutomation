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
        $macAddressHexadecimal = str_replace(':', '', $this->getMac());
        // check if $macAddress is a valid mac address
        if (!ctype_xdigit($macAddressHexadecimal)) {
            throw new \Exception('Mac address invalid, only 0-9 and a-f are allowed');
        }
        $macAddressBinary = pack('H12', $macAddressHexadecimal);
        $magicPacket      = str_repeat(chr(0xff), 6).str_repeat($macAddressBinary, 16);
        if (!$fp = fsockopen('udp://'.'255.255.255.0', 7, $errno, $errstr, 2)) {
            throw new \Exception("Cannot open UDP socket: {$errstr}", $errno);
        }
        fputs($fp, $magicPacket);
        fclose($fp);
    }
}
