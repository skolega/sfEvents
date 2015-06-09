<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Place;
use AppBundle\Form\PlaceType;

/**
 * Place controller.
 *
 * @Route("/place")
 */
class PlaceController extends Controller
{

    /**
     * Lists all Place entities.
     *
     * @Route("/", name="place")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Place');

        $places = $em->findAll();

        $placesCities = $em->getPlacesCities();
        $placesCategories = $this->getDoctrine()
                ->getRepository('AppBundle:Category')
                ->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $places, $request->query->get('page', 1), 12
        );
        return $this->render('Place/list.html.twig', array(
                    'places' => $pagination,
                    'allPlaces' => $placesCities,
                    'categories' => $placesCategories,
        ));
    }

    /**
     * Creates a new Place entity.
     *
     * @Route("/", name="place_create")
     * @Method("POST")
     * @Template("AppBundle:Place:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Place();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('place_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Place entity.
     *
     * @param Place $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Place $entity)
    {
        $form = $this->createForm(new PlaceType(), $entity, array(
            'action' => $this->generateUrl('place_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Place entity.
     *
     * @Route("/new", name="place_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Place();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Place entity.
     *
     * @Route("/{id}", name="place_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Place')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Place entity.
     *
     * @Route("/{id}/edit", name="place_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Place')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Place entity.
     *
     * @param Place $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Place $entity)
    {
        $form = $this->createForm(new PlaceType(), $entity, array(
            'action' => $this->generateUrl('place_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Place entity.
     *
     * @Route("/{id}", name="place_update")
     * @Method("PUT")
     * @Template("AppBundle:Place:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Place')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Place entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('place_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Place entity.
     *
     * @Route("/{id}", name="place_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Place')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Place entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('place'));
    }

    /**
     * Creates a form to delete a Place entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('place_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * @Route("/disable/place")
     * @Template()
     */
    public function disableAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/search/place", name="place_search")
     */
    public function searchAction(Request $request)
    {
        $city = $request->query->get('city');
        $category = $request->query->get('category');

        $pagination = null;

        $em = $this->getDoctrine()->getRepository('AppBundle:Place');

        $placesCities = $em->getPlacesCities();
        $placesCategories = $this->getDoctrine()
                ->getRepository('AppBundle:Category')
                ->findAll();

        if ($city && $category == '') {
            $places = $em->searchPlacesByCity($city);
        } elseif ($city == '' && $category) {
            $places = $em->searchPlacesByCategory($category);
        } elseif ($city && $category) {
            $places = $em->searchPlacesByCityAndCategory($city, $category);
        } else {
            $this->addFlash('danger', 'Aby wyszukać miejscówki musisz wpisać jakąś frazę');
            $places = $em->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $places, $request->query->get('page', 1), 12
        );
        return $this->render('Place/list.html.twig', array(
                    'places' => $pagination,
                    'allPlaces' => $placesCities,
                    'categories' => $placesCategories,
                    'city' => $city,
                    'category' => $category,
        ));
    }

    /**
     * @Route("/signIn/place")
     * @Template()
     */
    public function signInAction()
    {
        return array(
                // ...
        );
    }

}
