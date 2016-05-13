<?php
/**
 * Created with PhpStorm at 17.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 *
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 *
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route("/devices", name="admin_devices_route")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function devicesAction(Request $request)
    {
        $devices = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:Device')->findAll();
        
        return $this->render('@App/admin/devices.html.twig', ['devices' => $devices]);
    }

    /**
     * @Route("/users", name="admin_users_route")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')->getRepository('AppBundle:User')->findAll();
        
        return $this->render('@App/admin/users.html.twig', ['users' => $users]);
    }
}
