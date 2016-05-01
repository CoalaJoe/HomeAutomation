<?php
/**
 * Created with PhpStorm at 01.05.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Level;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadLevelData
 *
 * @package AppBundle\DataFixtures\ORM
 */
class LoadLevelData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $eg = new Level(0, 'Erdgeschoss');
        $manager->persist($eg);
        $this->setReference('eg', $eg);
        
        $lev1 = new Level(1, '1. Stock');
        $manager->persist($lev1);
        $this->setReference('lev1', $lev1);
        
        $lev2 = new Level(2, '2. Stock');
        $manager->persist($lev2);
        $this->setReference('lev2', $lev2);
        
        $manager->flush();
    }

}
