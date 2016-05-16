<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Settings;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/api/user")
 */
class UserController extends Controller
{

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="api_user_new", options={"expose": true})
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.encoder_factory')->getEncoder(new User());
            $user->setPassword($encoder->encodePassword($user->getPassword(), null));
            $em->persist($user);
            $em->flush();

            return new Response('Ok', 201);
        }

        return $this->render('AppBundle:user:new.html.twig', array(
                'user' => $user,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="api_user_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param User    $user
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm   = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('api_user_edit', array('id' => $user->getId()));
        }

        return $this->render('AppBundle:user:edit.html.twig', array(
                'user'        => $user,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()->setAction($this->generateUrl('api_user_delete', array('id' => $user->getId())))->setMethod('DELETE')->getForm();
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="api_user_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param User    $user
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_users_route');
    }
}
