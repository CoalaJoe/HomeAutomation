<?php
/**
 * Created with PhpStorm.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Services\NLP;


use AppBundle\DeviceHelper\Audio\VolumeChangeable;
use AppBundle\DeviceHelper\SmartTVInterface;
use AppBundle\DeviceHelper\StandByChangeable;
use AppBundle\Entity\Device;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CommandMapper
{
    private $stopWords = [];

    /**
     * @var User
     */
    private $user;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
        $stopWords = file_get_contents(__DIR__.'/data/stopwords-de.txt');
        $stopWords = explode("\n", $stopWords);
        foreach ($stopWords as $stopWord) {
            $this->stopWords[] = $stopWord;
        }
    }

    public function mapCommand(string $string)
    {
        $filteredText = $this->filterStopWords($string);
        switch ($filteredText) {
            case $this->matchesCommand($filteredText, ['Fernseher'], ['an', 'ein', 'anschalten', 'einschalten']):
                $action = 'ein';
            case $this->matchesCommand($filteredText, ['Fernseher'], ['aus', 'ausschalten']):
                $action = $action ?? 'aus';
                $devices = $this->user->getSettings()->getRoom()->getDevices();
                $tvs = [];
                foreach ($devices as $device) {
                    /** @var Device $device */
                    if ($device instanceof SmartTVInterface && $device instanceof StandByChangeable) {
                        $tvs[] = $device;
                    }
                }
                if (count($tvs) !== 0) {
                    /** @var SmartTVInterface|StandByChangeable $tv */
                    $tv = $tvs[0]; // TODO: Get all matching Devices. Get status. If action "an" and none is on throw error message.
                    $status = $tv->getPowerStatus();
                    if (($status === StandByChangeable::STATUS_OFF && $action === 'aus') || ($status === StandByChangeable::STATUS_ON && $action === 'ein')) {
                        return $this->createErrorResult("Das ist bereits der aktuelle Zustand.");
                    } else {
                        $tv->commandStandBy();
                    }
                }

                return $this->createSuccessResult("Fernseher wird ".$action."geschalten.");
            case $this->matchesCommand($filteredText, ['Fernseher'], ['leiser', 'leise']):
                $action = "leiser";
            case $this->matchesCommand($filteredText, ['Fernseher'], ['lauter', 'laute']):
                $action = $action ?? "lauter";
                $devices = $this->user->getSettings()->getRoom()->getDevices();
                $tvs = [];
                foreach ($devices as $device) {
                    /** @var Device $device */
                    if ($device instanceof SmartTVInterface && $device instanceof StandByChangeable) {
                        $tvs[] = $device;
                    }
                }
                if (count($tvs) !== 0) {
                    /** @var SmartTVInterface|StandByChangeable|VolumeChangeable $tv */
                    $tv = $tvs[0]; // TODO: Get all matching Devices. Get status. If action "an" and none is on throw error message.
                    $status = $tv->getPowerStatus();

                    if ($tv instanceof StandByChangeable && $status === StandByChangeable::STATUS_OFF) {
                        return $this->createErrorResult("Aber der Fernseher ist aus.");
                    } else {
                        $amount = 2;
                        foreach ($filteredText as $text) {
                            if (is_numeric($text)) {
                                $amount = (int)$text;
                            }
                        }
                        for ($i = 0; $i < $amount; ++$i) {
                            if ($action === 'lauter') {
                                $tv->commandVolumeUp();
                            } else {
                                $tv->commandVolumeDown();
                            }
                        }
                    }

                    return $this->createSuccessResult("Ich habe Ihn für dich um ". $amount . $action ." gestellt.");
                }

            default:
                return $this->createErrorResult("Diesen Befehl kenne ich nicht.");
        }
    }

    private function filterStopWords(string $text)
    {
        $text = str_replace('.', '', $text);
        $textArr = explode(' ', $text);
        $filtered = [];
        foreach ($textArr as $word) {
            if (!in_array(strtolower($word), $this->stopWords)) {
                $filtered[] = $word;
            }
        }

        return $filtered;
    }

    private function matchesCommand($array, $must = [], $or = [], $donts = ['nicht'])
    {
        $searchArray = array_map('strtolower', $array);
        foreach ($must as $m) {
            if (!in_array(strtolower($m), $searchArray)) {

                return false;
            }
        }

        foreach ($donts as $d) {
            if (in_array(strtolower($d), $searchArray)) {

                return false;
            }
        }

        if (count($or) !== 0) {
            $orCount = 0;
            foreach ($or as $o) {
                if (in_array(strtolower($o), $searchArray)) {
                    ++$orCount;
                }
            }
            if ($orCount === 0) { return false; }
        }

        return true;
    }

    private function createSuccessResult($text)
    {
        return [
            'status'  => 200,
            'message' => $text,
        ];
    }

    private function createErrorResult($text)
    {
        return [
            'status'  => 409,
            'message' => $text,
        ];
    }
}
