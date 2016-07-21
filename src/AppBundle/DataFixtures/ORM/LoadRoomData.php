<?php
/**
 * Created with PhpStorm at 15.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Room;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadRoomData
 *
 * @package AppBundle\DataFixtures\ORM
 */
class LoadRoomData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entrance = new Room('Eingang', $this->getReference('eg'));
        $manager->persist($entrance);

        $washroom = new Room('Waschküche', $this->getReference('eg'));
        $manager->persist($washroom);

        $fathersRoom = new Room('Vaters Hobbyraum', $this->getReference('eg'));
        $manager->persist($fathersRoom);

        $livingroom = new Room('Wohnzimmer', $this->getReference('lev1'));
        $this->addReference('Wohnzimmer', $livingroom);
        $manager->persist($livingroom);

        $kitchen = new Room('Küche', $this->getReference('lev1'));
        $manager->persist($kitchen);

        $corridor = new Room('Gang', $this->getReference('lev1'));
        $manager->persist($corridor);

        $bathroom = new Room('Badezimmer', $this->getReference('lev1'));
        $manager->persist($bathroom);

        $parentsBedroom = new Room('Schlafzimmer', $this->getReference('lev1'));
        $manager->persist($parentsBedroom);

        $balcony = new Room('Balkon', $this->getReference('lev1'));
        $manager->persist($balcony);

        $upperCorridor = new Room('Gang', $this->getReference('lev2'));
        $manager->persist($upperCorridor);

        $upperBathroom = new Room('Badezimmer', $this->getReference('lev2'));
        $manager->persist($upperBathroom);

        $mothersRoom = new Room('Mutters Hobbyzimmer', $this->getReference('lev2'));
        $manager->persist($mothersRoom);

        $personalRoom = new Room('Dominiks Zimmer', $this->getReference('lev2'));
        $this->addReference('Dominiks Zimmer', $personalRoom);
        $manager->persist($personalRoom);

        $upperBalcony = new Room('Balkon', $this->getReference('lev2'));
        $manager->persist($upperBalcony);


        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
