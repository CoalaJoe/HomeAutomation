<?php
/**
 * Created with PhpStorm at 19.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Entity;


use AppBundle\DeviceHelper\Audio\Mutable;
use AppBundle\DeviceHelper\SmartTV\SubtitleChangeable;
use AppBundle\DeviceHelper\Audio\VolumeChangeable;
use AppBundle\DeviceHelper\Authorizable;
use AppBundle\DeviceHelper\SmartTV\BackToMenu;
use AppBundle\DeviceHelper\SmartTV\ChannelChangeable;
use AppBundle\DeviceHelper\SmartTV\Enterable;
use AppBundle\DeviceHelper\SmartTV\Navigatable;
use AppBundle\DeviceHelper\SmartTVInterface;
use AppBundle\DeviceHelper\StandByChangeable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SonyBraviaSmartTV
 *
 * @ORM\Entity()
 *
 * @package AppBundle\Entity
 */
class SonyBraviaSmartTV extends Device implements SmartTVInterface, StandByChangeable, ChannelChangeable, Authorizable, VolumeChangeable, Mutable, Navigatable, Enterable, BackToMenu, SubtitleChangeable
{
    const COMMAND_POWER_OFF                  = 'AAAAAQAAAAEAAAAvAw==';
    const COMMAND_POWER_ON                   = 'AAAAAQAAAAEAAAAuAw==';
    const COMMAND_VOLUME_DOWN                = 'AAAAAQAAAAEAAAATAw==';
    const COMMAND_VOLUME_UP                  = 'AAAAAQAAAAEAAAASAw==';
    const COMMAND_MUTE_TOGGLE                = 'AAAAAQAAAAEAAAAUAw==';
    const COMMAND_CHANNEL_DOWN               = 'AAAAAQAAAAEAAAARAw==';
    const COMMAND_CHANNEL_UP                 = 'AAAAAQAAAAEAAAAQAw==';
    const COMMAND_CHANNEL_PREVIOUS           = 'AAAAAQAAAAEAAAA7Aw==';
    const COMMAND_CURSOR_DOWN                = 'AAAAAQAAAAEAAAB1Aw==';
    const COMMAND_CURSOR_UP                  = 'AAAAAQAAAAEAAAB0Aw==';
    const COMMAND_CURSOR_RIGHT               = 'AAAAAQAAAAEAAAAzAw==';
    const COMMAND_CURSOR_LEFT                = 'AAAAAQAAAAEAAAA0Aw==';
    const COMMAND_CURSOR_ENTER               = 'AAAAAQAAAAEAAABlAw==';
    const COMMAND_HOME_MENU                  = 'AAAAAQAAAAEAAABgAw==';
    const COMMAND_EXIT                       = 'AAAAAQAAAAEAAABjAw==';
    const COMMAND_RETURN                     = 'AAAAAgAAAJcAAAAjAw==';
    const COMMAND_DISPLAY                    = 'AAAAAQAAAAEAAAA6Aw==';
    const COMMAND_GUIDE                      = 'AAAAAgAAAKQAAABbAw==';
    const COMMAND_NUM_ZERO                   = 'AAAAAQAAAAEAAAAJAw==';
    const COMMAND_NUM_ONE                    = 'AAAAAQAAAAEAAAAAAw==';
    const COMMAND_NUM_TWO                    = 'AAAAAQAAAAEAAAABAw==';
    const COMMAND_NUM_THREE                  = 'AAAAAQAAAAEAAAACAw==';
    const COMMAND_NUM_FOUR                   = 'AAAAAQAAAAEAAAADAw==';
    const COMMAND_NUM_FIVE                   = 'AAAAAQAAAAEAAAAEAw==';
    const COMMAND_NUM_SIX                    = 'AAAAAQAAAAEAAAAFAw==';
    const COMMAND_NUM_SEVEN                  = 'AAAAAQAAAAEAAAAGAw==';
    const COMMAND_NUM_EIGHT                  = 'AAAAAQAAAAEAAAAHAw==';
    const COMMAND_NUM_NINE                   = 'AAAAAQAAAAEAAAAIAw==';
    const COMMAND_NUM_TEN                    = 'AAAAAgAAAJcAAAAMAw==';
    const COMMAND_DIGIT_SEPARATOR            = 'AAAAAgAAAJcAAAAdAw==';
    const COMMAND_MENU_POPUP                 = 'AAAAAgAAABoAAABhAw==';
    const COMMAND_FUNCTION_RED               = 'AAAAAgAAAJcAAAAlAw==';
    const COMMAND_FUNCTION_YELLOW            = 'AAAAAgAAAJcAAAAnAw==';
    const COMMAND_FUNCTION_GREEN             = 'AAAAAgAAAJcAAAAmAw==';
    const COMMAND_FUNCTION_BLUE              = 'AAAAAgAAAJcAAAAkAw==';
    const COMMAND_3D                         = 'AAAAAgAAAHcAAABNAw==';
    const COMMAND_SUBTITLE_ON                = 'AAAAAgAAAJcAAAAoAw==';
    const COMMAND_SUBTITLE_OFF               = 'AAAAAgAAAKQAAAAQAw==';
    const COMMAND_HELP                       = 'AAAAAgAAABoAAAB7Aw=='; // TODO: test
    const COMMAND_SYNC_MENU                  = 'AAAAAgAAABoAAABYAw==';
    const COMMAND_OPTIONS                    = 'AAAAAgAAAJcAAAA2Aw==';
    const COMMAND_INPUT_TOGGLE               = 'AAAAAQAAAAEAAAAlAw==';
    const COMMAND_WIDE                       = 'AAAAAgAAAKQAAAA9Aw==';
    const COMMAND_SONY_ENTERTAINMENT_NETWORK = 'AAAAAgAAABoAAAB9Aw==';
    const COMMAND_MEDIA_PAUSE                = 'AAAAAgAAAJcAAAAZAw==';
    const COMMAND_MEDIA_PLAY                 = 'AAAAAgAAAJcAAAAaAw==';
    const COMMAND_MEDIA_STOP                 = 'AAAAAgAAAJcAAAAYAw==';
    const COMMAND_MEDIA_FORWARD              = 'AAAAAgAAAJcAAAAcAw==';
    const COMMAND_MEDIA_REVERSE              = 'AAAAAgAAAJcAAAAbAw==';
    const COMMAND_MEDIA_PREVIOUS             = 'AAAAAgAAAJcAAAA8Aw==';
    const COMMAND_MEDIA_NEXT                 = 'AAAAAgAAAJcAAAA9Aw==';
    const COMMAND_ANALOG                     = 'AAAAAgAAAHcAAAANAw==';
    const COMMAND_DIGITAL                    = 'AAAAAgAAAJcAAAAyAw==';
    const COMMAND_AUDIO                      = 'AAAAAQAAAAEAAAAXAw=='; // TODO: test
    const COMMAND_PICTURE_AND_PICTURE        = 'AAAAAgAAAKQAAAB3Aw==';
    const COMMAND_INPUT_HDMI1                = 'AAAAAgAAABoAAABaAw==';
    const COMMAND_INPUT_HDMI2                = 'AAAAAgAAABoAAABbAw==';
    const COMMAND_INPUT_HDMI3                = 'AAAAAgAAABoAAABcAw==';
    const COMMAND_INPUT_HDMI4                = 'AAAAAgAAABoAAABdAw==';
    const COMMAND_NETFLIX                    = 'AAAAAgAAABoAAAB8Aw==';

    // NOT TESTED
    const COMMAND_ADVANCE             = 'AAAAAgAAAJcAAAB4Aw==';
    const COMMAND_TOP_MENU            = 'AAAAAgAAABoAAABgAw==';
    const COMMAND_TELETEXT            = 'AAAAAQAAAAEAAAA/Aw==';
    const COMMAND_GGUIDE              = 'AAAAAQAAAAEAAAAOAw==';
    const COMMAND_BS                  = 'AAAAAgAAAJcAAAAsAw==';
    const COMMAND_CS                  = 'AAAAAgAAAJcAAAArAw==';
    const COMMAND_CSBS                = 'AAAAAgAAAJcAAAAQAw==';
    const COMMAND_DDATA               = 'AAAAAgAAAJcAAAAVAw==';
    const COMMAND_INTERNET_WIDGETS    = 'AAAAAgAAABoAAAB6Aw==';
    const COMMAND_INTERNET_VIDEO      = 'AAAAAgAAABoAAAB5Aw==';
    const COMMAND_SCENE_SELECT        = 'AAAAAgAAABoAAAB4Aw==';
    const COMMAND_MY_EPG              = 'AAAAAgAAAHcAAABrAw==';
    const COMMAND_PROGRAM_DESCRIPTION = 'AAAAAgAAAJcAAAAWAw==';
    const COMMAND_WRITE_CHAPTER       = 'AAAAAgAAAHcAAABsAw==';
    const COMMAND_TRACK_ID            = 'AAAAAgAAABoAAAB+Aw==';
    const COMMAND_APPLI_CAST          = 'AAAAAgAAABoAAABvAw==';
    const COMMAND_DELETE_VIDEO        = 'AAAAAgAAAHcAAAAfAw==';
    const COMMAND_EASY_STARTUP        = 'AAAAAgAAAHcAAABqAw==';
    const COMMAND_ONE_TOUCH_TIME_REC  = 'AAAAAgAAABoAAABkAw==';
    const COMMAND_ONE_TOUCH_VIEW      = 'AAAAAgAAABoAAABlAw==';
    const COMMAND_ONE_TOUCH_REC       = 'AAAAAgAAABoAAABiAw==';
    const COMMAND_ONE_TOUCH_REC_STOP  = 'AAAAAgAAABoAAABjAw==';

    /**
     * SonyBraviaSmartTV constructor.
     *
     * @param string $ip
     * @param Room   $room
     */
    public function __construct(string $ip, Room $room)
    {
        parent::__construct($ip, $room, '', true, false);
        $this->setIcon('tv');
    }

    /**
     * @param null $interfaces
     *
     * @return array
     */
    public function getCommands($interfaces = null):array
    {
        $commands = parent::getCommands(class_implements(__CLASS__));
        $commands += $this->getInputs();

        return $commands;
    }

    /**
     * @return array
     */
    public function getInputs():array
    {
        return [
            'HDMI 1'  => ['settings_input_hdmi' => 'commandHDMI1'],
            'HDMI 2'  => ['settings_input_hdmi' => 'commandHDMI2'],
            'HDMI 3'  => ['settings_input_hdmi' => 'commandHDMI3'],
            'HDMI 4'  => ['settings_input_hdmi' => 'commandHDMI4'],
            'Digital' => ['settings_input_hdmi' => 'commandDigital']
        ];
    }

    /**
     * @return mixed
     */
    public function commandChannelUp()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CHANNEL_UP));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @param string $url
     *
     * @return resource
     */
    protected function getBaseCurl(string $url)
    {
        $cookieFile = __DIR__.'/../AuthCache/sonyBravia'.$this->getId().'.txt';
        if (!file_exists($cookieFile)) {
            $handle = fopen($cookieFile, 'w');
            fclose($handle);
        }

        $curl = parent::getBaseCurl($url);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 2000);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['SOAPAction: "urn:schemas-sony-com:service:IRCC:1#X_SendIRCC"']);
        curl_setopt($curl, CURLOPT_POST, 1);

        return $curl;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getIp().'/sony/IRCC';
    }

    /**
     * @param string $command
     *
     * @return string
     */
    private function getXMLRequest(string $command)
    {
        return '<?xml version="1.0" encoding="utf-8"?><s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/" s:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><s:Body><u:X_SendIRCC xmlns:u="urn:schemas-sony-com:service:IRCC:1"><IRCCCode>'.$command.'</IRCCCode></u:X_SendIRCC></s:Body></s:Envelope>';
    }

    /**
     * @return mixed
     */
    public function commandChannelDown()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CHANNEL_DOWN));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandChannelPrevious()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CHANNEL_PREVIOUS));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function requestAccess()
    {
        $curl = $this->getBaseCurl($this->getIp().'/sony/accessControl');
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            '{"id":14,"method":"actRegister","version":"1.0","params":[{"clientid":"HomeAutomation:1","nickname":"HomeAutomation"},[{"clientid":"HomeAutomation:1","value":"yes","nickname":"HomeAutomation","function":"WOL"}]]}'
        );

        $result = curl_exec($curl);
        curl_close($curl);


        return $result;
    }

    /**
     * @param $password
     *
     * @return mixed
     */
    public function authenticate($password)
    {
        $curl = $this->getBaseCurl($this->getIp().'/sony/accessControl');
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, ':'.$password);
        curl_setopt($curl, CURLOPT_POSTFIELDS,
            '{"id":14,"method":"actRegister","version":"1.0","params":[{"clientid":"HomeAutomation:1","nickname":"HomeAutomation"},[{"clientid":"HomeAutomation:1","value":"yes","nickname":"HomeAutomation","function":"WOL"}]]}'
        );
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result)->id === 14;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDeviceName();
    }

    /**
     * @return string
     */
    public function getDeviceName()
    {
        return 'Sony Smart TV';
    }


    /**
     * @return mixed
     */
    public function commandVolumeUp()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_VOLUME_UP));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandVolumeDown()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_VOLUME_DOWN));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandMute()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_MUTE_TOGGLE));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandStandBy()
    {
        // Get current status.
        $curl = $this->getBaseCurl($this->getIp().'/sony/system');
        curl_setopt($curl, CURLOPT_POSTFIELDS, '{"id":4,"method":"getPowerStatus","version":"1.0","params":[]}');
        $status = $this->getJson($curl);

        $curl = $this->getBaseCurl($this->getBaseUrl());

        if ($status->result[0]->status === 'standby') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_POWER_ON));
        } else {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_POWER_OFF));
        }

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandUp()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CURSOR_UP));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandDown()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CURSOR_DOWN));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandLeft()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CURSOR_LEFT));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandRight()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CURSOR_RIGHT));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandEnter()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_CURSOR_ENTER));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandBackToMenu()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_HOME_MENU));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandSubtitle()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_SUBTITLE_ON)); // TODO: test

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandHDMI1()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_INPUT_HDMI1));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandHDMI2()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_INPUT_HDMI2));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandHDMI3()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_INPUT_HDMI3));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandHDMI4()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_INPUT_HDMI4));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return mixed
     */
    public function commandDigital()
    {
        $curl = $this->getBaseCurl($this->getBaseUrl());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getXMLRequest(self::COMMAND_DIGITAL));

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * @return array
     */
    public function getTemplateCommands()
    {
        $powerToggle = parent::getCommands('AppBundle\DeviceHelper\StandByChangeable');
        $menuButton  = parent::getCommands('AppBundle\DeviceHelper\SmartTV\BackToMenu');
        $navigation  = parent::getCommands('AppBundle\DeviceHelper\SmartTV\Navigatable');
        $volume      = parent::getCommands('AppBundle\DeviceHelper\Audio\VolumeChangeable');

        return $powerToggle + $menuButton + $navigation + $volume + $this->getInputs();
    }

    /**
     * @param string $namespace
     *
     * @return array
     */
    public function getButton(string $namespace)
    {

        return parent::getCommands($namespace);
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return "sonySmartTv";
    }
}
