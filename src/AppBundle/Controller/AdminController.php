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
        return $this->render('@App/admin/devices.html.twig');
    }
}
