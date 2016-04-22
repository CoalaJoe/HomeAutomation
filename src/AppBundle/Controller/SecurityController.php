<?php
/**
 * Created with PhpStorm at 15.04.16.
 *
 * @author Dominik Müller (Ashura) ashura@aimei.ch
 * @link   http://aimei.ch/developers/Ashura
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityController
 *
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $usernames = $this->get('doctrine.orm.entity_manager')->createQueryBuilder()->select('u.username')->from('AppBundle:User', 'u')->where("u.username != 'admin'")->getQuery()
            ->getResult();

        return $this->render('AppBundle:security:login.html.twig', array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'usernames'     => $usernames
            )
        );
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @param Request $request
     */
    public function logoutAction(Request $request)
    {
        // nothing
    }
}
