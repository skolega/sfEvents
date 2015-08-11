<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Entity\Team;
use AppBundle\Form\TeamTeamsType;
use AppBundle\Form\TeamType;
use AppBundle\Form\MyTeamType;

/**
 * Team controller.
 *
 * @Route("/team")
 */
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
     * @Route("/add/myteam/{event}", name="add_my_team")
     */
    public function addMyTeamAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = new Team();
        $userId = $this->getUser()->getId();

        $form = $this->createForm(new TeamTeamsType(array('user_id' => $userId)), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $event->addTeam($form["name"]->getData());
            $em->flush();

            return $this->redirectToRoute('show_event', [
                        'id' => $event->getId()
            ]);
        }

        return $this->render('Team/add.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $event->getId(),
        ));
    }

    /**
     * @Route("/add/team/{event}", name="add_team")
     */
    public function addTeamAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = new Team();

        $form = $this->createForm(new TeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($team);
            $event->addTeam($team);
            $em->flush();

            return $this->redirectToRoute('show_event', [
                        'id' => $event->getId()
            ]);
        }

        return $this->render('Team/addTeam.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $event->getId()
        ));
    }
    
    /**
     * @Route("/remove/team/{event}/{team}", name="remove_team_from_event")
     */
    public function removeTeamAction(Event $event, Team $team)
    {

        $em = $this->getDoctrine()->getManager();

        $event->removeTeam($team);

        $em->flush();

        $notify = $this->get('notification');
//        $notify->addTeamNotification($user, $event, $team, 2);

//        $this->addFlash('success', sprintf('Drużyna "%s" została wypisana z eventu', $this->getUser()->getUsername()));

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
     * @Route("/create", name="create_myTeam")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = new Team();
        $user = $this->getUser();

        $form = $this->createForm(new MyTeamType(), $team);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $team->addTeamAdmin($user);
            $user->addTeam($team);
            $team->setType(2);
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('index_team', [
                        'id' => $team->getId()
            ]);
        }

        return $this->render('Team/addMyTeam.html.twig', array(
                    'form' => $form->createView(),
        ));
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

    /**
     * @Route("/index", name="index_team")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $teams = $em->getRepository('AppBundle:Team')
                ->getMyTeams($user->getId());

        return $this->render('Team/index.html.twig', [
                    'teams' => $teams,
        ]);
    }

    /**
     * @Route("/show/{team}", name="show_team")
     */
    public function showAction($team)
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Team')
                ->findOneBy(['id' => $team]);

        return $this->render('Team/show.html.twig', [
                    'single' => $teams,
        ]);
    }

    /**
     * @Route("/invite/friends/{team}", name="invite_friend")
     */
    public function inviteAction($team)
    {
        $em = $this->getDoctrine()->getManager();
        $teamObject = $em->getRepository('AppBundle:Team')
                ->findOneBy(['id' => $team]);
        
        $user = $this->getUser();

        $friends = $user->getMyFriends();        

        return $this->render('Team/inviteFriend.html.twig', [
                    'friends' => $friends,
                    'team' => $teamObject,
        ]);
    }

    /**
     * @Route("/addfriend/{team}/{friend}", name="add_team_friend")
     */
    public function addFriendAction($team, $friend)
    {
        $em = $this->getDoctrine()->getManager();
        
        $teamObject = $em->getRepository('AppBundle:Team')
                ->findOneBy(['id' => $team]);
        $friendObject = $em->getRepository('AppBundle:User')
                ->findOneBy(['id' => $friend]);

        $friendObject->addTeam($teamObject);
        
        $em->flush();
        
        return $this->render('Team/show.html.twig', [
                    'single' => $teamObject,
        ]);
    }

}
