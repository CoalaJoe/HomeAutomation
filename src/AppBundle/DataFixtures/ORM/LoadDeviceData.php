<?php
/**
 * Created with PhpStorm at 19.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\SonyBraviaSmartTV;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadDeviceData
 *
 * @package AppBundle\DataFixtures\ORM
 */
class LoadDeviceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $sonySmartTV = new SonyBraviaSmartTV('192.168.1.129', $this->getReference('Dominiks Zimmer'));
        $sonySmartTV->setMac('AC:9B:0A:3C:25:7A');
        $manager->persist($sonySmartTV);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
