<?php
/**
 * Created with PhpStorm.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;


/**
 * Class UserCreateListener
 *
 * @package AppBundle\EventListener
 */
class UserCreateListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $entityManager = $args->getEntityManager();

        if ($entity->getSettings()->getRoom() === null) {
            $room = $entityManager->getRepository('AppBundle:Room')->findOneBy(['name' => 'Wohnzimmer']);
            $entity->getSettings()->setRoom($room);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}
