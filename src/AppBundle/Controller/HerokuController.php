<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Heroku;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Heroku controller.
 *
 * @Route("heroku")
 */
class HerokuController extends Controller
{
    /**
     * Lists all heroku entities.
     *
     * @Route("/", name="heroku_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $herokus = $em->getRepository('AppBundle:Heroku')->findAll();

        return $this->render('heroku/index.html.twig', array(
            'herokus' => $herokus,
        ));
    }

    /**
     * Creates a new heroku entity.
     *
     * @Route("/new", name="heroku_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $heroku = new Heroku();
        $form = $this->createForm('AppBundle\Form\HerokuType', $heroku);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($heroku);
            $em->flush($heroku);

            return $this->redirectToRoute('heroku_show', array('id' => $heroku->getId()));
        }

        return $this->render('heroku/new.html.twig', array(
            'heroku' => $heroku,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a heroku entity.
     *
     * @Route("/{id}", name="heroku_show")
     * @Method("GET")
     */
    public function showAction(Heroku $heroku)
    {
        $deleteForm = $this->createDeleteForm($heroku);

        return $this->render('heroku/show.html.twig', array(
            'heroku' => $heroku,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing heroku entity.
     *
     * @Route("/{id}/edit", name="heroku_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Heroku $heroku)
    {
        $deleteForm = $this->createDeleteForm($heroku);
        $editForm = $this->createForm('AppBundle\Form\HerokuType', $heroku);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('heroku_edit', array('id' => $heroku->getId()));
        }

        return $this->render('heroku/edit.html.twig', array(
            'heroku' => $heroku,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a heroku entity.
     *
     * @Route("/{id}", name="heroku_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Heroku $heroku)
    {
        $form = $this->createDeleteForm($heroku);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($heroku);
            $em->flush($heroku);
        }

        return $this->redirectToRoute('heroku_index');
    }

    /**
     * Creates a form to delete a heroku entity.
     *
     * @param Heroku $heroku The heroku entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Heroku $heroku)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('heroku_delete', array('id' => $heroku->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
