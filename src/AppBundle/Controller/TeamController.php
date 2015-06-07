<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Event;
use AppBundle\Entity\Team;

class TeamController extends Controller
{

    /**
     * @Route("/list/{id}")
     */
    public function listAction(Event $event)
    {

        $teams = $this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder()
                        ->select('t')
                        ->from('AppBundle:Team', 't')
                        ->join('t.event', 'e')
                        ->where('e.id = :event')
                        ->setParameter('event', $event)
                        ->getQuery()->getResult();

        $user = $this->getUser();

        $usersInTeams = false;
        $userInPlayers = false;

        $players = $event->getPlayers();

        if ($players) {
            foreach ($players as $player) {
                if ($user == $player) {
                    $userInPlayers = true;
                }
            }
        }
        if ($teams) {
            foreach ($teams as $team) {
                $players = $team->getPlayers();
                foreach ($players as $player) {
                    if ($user->getId() == $player->getId()) {
                        $usersInTeams = true;
                    }
                }
            }
        }

        return $this->render('Team/list.html.twig', [
                    'teams' => $teams,
                    'events' => $event,
                    'inTeams' => $usersInTeams,
                    'inPlayers' => $userInPlayers,
        ]);
    }

    /**
     * @Route("/add/team/{team}/{event}", name="add_user_to_team")
     */
    public function addAction(Team $team, Event $event)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user->addTeam($team);

        $em->flush();

        $notify = $this->get('notification');
        $notify->addTeamNotification($user, $event, $team, 1);

        $this->addFlash('success', sprintf('Użytkownik "%s" został dodany do drużyny', $this->getUser()->getUsername()));

        return $this->redirectToRoute('show_event', [
                    'id' => $event->getId()
        ]);
    }

    /**
     * @Route("/remove/team/{team}/{event}", name="remove_user_from_team")
     */
    public function removeAction(Team $team, Event $event)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $user->removeTeam($team);

        $em->flush();

        $notify = $this->get('notification');
        $notify->addTeamNotification($user, $event, $team, 2);

        $this->addFlash('success', sprintf('Użytkownik "%s" został wypisany z drużyny', $this->getUser()->getUsername()));

        return $this->redirectToRoute('show_event', [
                    'id' => $event->getId()
        ]);
    }

    /**
     * @Route("/create")
     */
    public function createAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/close")
     * @Template()
     */
    public function closeAction()
    {
        return array(
                // ...
        );
    }

}
