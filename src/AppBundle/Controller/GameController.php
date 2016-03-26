<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Entity\Event;
use AppBundle\Entity\Score;
use AppBundle\Entity\Team;
use AppBundle\Form\GameScoreType;

/**
 * Game controller.
 *
 * @Route("/game")
 */
class GameController extends Controller
{

    /**
     * Lists all Game entities.
     *
     * @Route("/", name="game")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Game')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Game entity.
     *
     * @Route("/", name="game_create")
     * @Method("POST")
     * @Template("AppBundle:Game:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Game();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('game_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Game entity.
     *
     * @param Game $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Game $entity)
    {
        $form = $this->createForm(new GameType(), $entity, array(
            'action' => $this->generateUrl('game_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Game entity.
     *
     * @Route("/new", name="game_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Game();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Game entity.
     *
     * @Route("/{id}", name="game_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     * @Route("/{id}/edit", name="game_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
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
     * Creates a form to edit a Game entity.
     *
     * @param Game $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Game $entity)
    {
        $form = $this->createForm(new GameType(), $entity, array(
            'action' => $this->generateUrl('game_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Game entity.
     *
     * @Route("/{id}", name="game_update")
     * @Method("PUT")
     * @Template("AppBundle:Game:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Game')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Game entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('game_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Game entity.
     *
     * @Route("/{id}", name="game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Game')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Game entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('game'));
    }

    /**
     * Creates a form to delete a Game entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('game_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Lists all Game entities.
     *
     * @Route("/{id}", name="list_event_games")
     */
    public function indexEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $event = $em->getRepository('AppBundle:Event')->find($id);

        $entities = $em->getRepository('AppBundle:Game')->getGameByEvent($event);
        
        $teams = $event->getTeams();

        return $this->render('Game\indexEvent.html.twig', array(
            'entities' => $entities,
            'teams' => $teams,
        ));
    }
    
    /**
     * @Route("/addgamescore/{event}", name="add_score")
     */
    public function addScoreAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $teams = $event->getTeams();
        
        $game = new Game();

        $score1 = new Score();
        $score1->name = 'score1';
        $game->getScores()->add($score1);
        $score2 = new Score();
        $score2->name = 'score2';
        $game->getScores()->add($score2);


        $form = $this->createForm(new GameScoreType(), $game);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $score1->addTeam($teams[0]);
            $score2->addTeam($teams[1]);
            $score1->setGame($game);
            $score2->setGame($game);
            $game->addScore($score1);
            $game->addScore($score2);
            $game->setPlayed(true);
            $game->setVerified(false);
            $game->addEvent($event);
            $game->setDate($event->getStartDate());
            
            $em->persist($score1);
            $em->persist($score2);
            $em->persist($game);
            
            $em->flush();
            
            return $this->redirectToRoute('show_event', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('AppBundle:Game:newScore.html.twig', array(
            'form' => $form->createView(),
            'single' => $event,
        ));
    }

}
