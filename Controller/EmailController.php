<?php

namespace Citrax\Bundle\DatabaseSwiftMailerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Citrax\Bundle\DatabaseSwiftMailerBundle\Entity\Email;
use Citrax\Bundle\DatabaseSwiftMailerBundle\Form\EmailType;

/**
 * Email controller.
 *
 * @Route("/email-spool")
 */
class EmailController extends Controller
{

    /**
     * Lists all Email entities.
     *
     * @Route("/{page}", name="email-spool", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('CitraxDatabaseSwiftMailerBundle:Email')->getAllEmails();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page/*page number*/,
            30/*limit per page*/
        );
        return array(
            'entities' => $pagination,
        );
    }

    /**
     * Finds and displays a Email entity.
     *
     * @Route("/{id}/show", name="email-spool_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CitraxDatabaseSwiftMailerBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Email entity.
     *
     * @Route("/{id}/retry", name="email-spool_retry")
     * @Method("GET")
     */
    public function retryAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CitraxDatabaseSwiftMailerBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $entity->setStatus(Email::STATUS_READY);
        $entity->setRetries(0);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('email-spool'));
    }

    /**
     * Deletes a Email entity.
     *
     * @Route("/{id}", name="email-spool_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CitraxDatabaseSwiftMailerBundle:Email')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Email entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('email-spool'));
    }

    /**
     * Creates a form to delete a Email entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('email-spool_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
