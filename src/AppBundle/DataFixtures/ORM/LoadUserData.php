<?php
/**
 * Created with PhpStorm at 14.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 *
 * @package AppBundle\DataFixtures
 */
class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder(new User());

        $admin = new User();
        $admin->setUsername('admin')->setEmail('dominik-mu@hotmail.com')->setFirstname('Dominik')->setLastname('Müller')->setType(User::TYPE_ADMIN);
        $admin->setPassword($encoder->encodePassword('admin', $admin->getSalt()));

        $manager->persist($admin);
        $manager->flush();

        $admin = $manager->getRepository('AppBundle:User')->findOneBy(['username' => $admin->getUsername()]);
        $admin->getSettings()->setRoom($this->getReference('Wohnzimmer'));

        $manager->persist($admin);
        $manager->flush();
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 2;
    }


}
