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
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadRoomData
 *
 * @package AppBundle\DataFixtures\ORM
 */
class LoadRoomData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entrance = new Room('Eingang', 0);
        $manager->persist($entrance);

        $washroom = new Room('Waschküche', 0);
        $manager->persist($washroom);

        $fathersRoom = new Room('Vaters Hobbyraum', 0);
        $manager->persist($fathersRoom);

        $livingroom = new Room('Wohnzimmer', 1);
        $manager->persist($livingroom);

        $kitchen = new Room('Küche', 1);
        $manager->persist($kitchen);

        $corridor = new Room('Gang', 1);
        $manager->persist($corridor);

        $bathroom = new Room('Badezimmer', 1);
        $manager->persist($bathroom);

        $parentsBedroom = new Room('Schlafzimmer', 1);
        $manager->persist($parentsBedroom);

        $balcony = new Room('Balkon', 1);
        $manager->persist($balcony);

        $upperCorridor = new Room('Gang', 2);
        $manager->persist($upperCorridor);

        $upperBathroom = new Room('Badezimmer', 2);
        $manager->persist($upperBathroom);

        $mothersRoom = new Room('Mutters Hobbyzimmer', 2);
        $manager->persist($mothersRoom);

        $personalRoom = new Room('Dominiks Zimmer', 2);
        $this->addReference('Dominiks Zimmer', $personalRoom);
        $manager->persist($personalRoom);

        $upperBalcony = new Room('Balkon', 2);
        $manager->persist($upperBalcony);


        $manager->flush();
    }

}
