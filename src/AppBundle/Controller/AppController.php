<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Interfaces\Authorizable;
use AppBundle\Entity\Interfaces\Controllable;
use AppBundle\Entity\SonyBraviaSmartTV;
use AppBundle\Exception\DeviceNotAuthorizedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AppController
 *
 * @package AppBundle\Controller
 */
class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {

            return $this->render('AppBundle:app:index.html.twig');
        }
        $room = $this->getUser()->getSettings()->getRoom();
        if (!$room) {

            // redirect to choose room.
        }
        $devices = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Device')->findBy(['room' => $room->getId()]);

        $smartTv = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:SonyBraviaSmartTV')->find(2);
        $smartTv->setMac('afafafafafaf');
        dump($smartTv->getMac());

        /*
        try {
            $this->get('app_smart_tv_handler')->send($smartTv, 'getChannelUp');
        } catch (DeviceNotAuthorizedException $e) {
            $smartTv->requestAccess();

            return $this->redirectToRoute('app_authenticate_device_route', ['deviceId' => $smartTv->getId()]);
        } */

        return $this->render('AppBundle:app:overview.html.twig', ['devices' => $devices]);
    }

    /**
     * @Route("/room", name="app_room_route")
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function roomAction(Request $request)
    {
        return $this->render('AppBundle:app:room.html.twig');
    }

    /**
     * @Route("/authenticateDevice/{deviceId}", name="app_authenticate_device_route", requirements={"deviceId": "\d+"}, defaults={"deviceId": null})
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     *
     * @param Request $request
     * @param int     $deviceId
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function authenticateDeviceAction(Request $request, $deviceId)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        if ($deviceId) {
            $device = $em->createQueryBuilder()->select('d')->from('AppBundle:Device', 'd')->where('d.id = :id')->andWhere('d.authorized = 0')->setMaxResults(1)
                ->setParameter('id', $deviceId)->getQuery()->getResult();
            if (!$device) {
                throw new \Exception('Gerät nicht gefunden.');
            }

            // continue authentication

            return $this->render('AppBundle:app:authenticateDevice.html.twig', ['device' => $device[0], 'action' => 'enterPassword']);
        }

        $devices = $em->getRepository('AppBundle:Device')->findBy(['authorized' => false]);

        // Offer devices to authenticate

        return $this->render('AppBundle:app:authenticateDevice.html.twig', ['devices' => $devices]);
    }

    /**
     * @Route("/authenticateDevice", name="app_authenticate_device_form_route")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     *
     */
    public function authenticateDeviceFormAction(Request $request)
    {
        $values = $request->request;
        $em     = $this->get('doctrine.orm.entity_manager');
        if ($values->get('submit')) {
            switch ($values->get('action')) {
                case 'chooseDevice':
                    if ($values->get('device')) {
                        $device = $em->getRepository('AppBundle:Device')->find($values->get('device'));
                        if ($device instanceof Authorizable) {
                            $device->requestAccess();

                            return $this->redirectToRoute('app_authenticate_device_route', ['deviceId' => $device->getId()]);
                        }
                    }

                    break;
                case 'enterPassword': {
                    if ($values->get('password') && $values->get('deviceId')) {
                        $device = $em->getRepository('AppBundle:Device')->find($values->get('deviceId'));
                        if ($device instanceof Authorizable) {
                            $success = $device->authenticate($values->get('password'));
                            if ($success) {
                                $device->setAuthorized(true);
                                $em->persist($device);
                                $em->flush();

                                return $this->redirectToRoute('homepage');
                            }

                            return $this->redirectToRoute('homepage');
                        }
                    }

                    break;
                }
                default:

                    break;
            }

            return new Response('', 404);
        } else {
            return new Response('', 404);
        }
    }

    /**
     * @Route("/device/{id}", name="app_device_control_route", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_USER')")
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function deviceControlAction(Request $request, int $id)
    {
        $device = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Device')->find($id);
        if (!$device || !$device->isControllable()) {
            return new Response('', 404);
        }

        /** @var Controllable $device */
        $commands = $device->getCommands();

        return $this->render('@App/app/controlDevice.html.twig', ['device' => $device, 'commands' => $commands]);
    }
}
