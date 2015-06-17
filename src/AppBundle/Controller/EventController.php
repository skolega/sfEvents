<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use AppBundle\Form\EventType;
use AppBundle\Entity\Team;
use AppBundle\Form\MessageType;
use AppBundle\Entity\Message;

class EventController extends Controller
{

    /**
     * @Route("/add", name="add_event")
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $event = new Event();

        $team1 = new Team();
        $team1->setName('Czerwoni');
        $event->addTeam($team1);
        $team2 = new Team();
        $team2->setName('Niebiescy');
        $event->addTeam($team2);

        $form = $this->createForm(new EventType(), $event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $event->setAdmin($user);
            $event->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $event->setEnabled(true);
            $event->addPlayer($user);
            $team1->addEvent($event);
            $team2->addEvent($event);
            $em->persist($event);
            $em->persist($team1);
            $em->persist($team2);
            $em->flush();

            $notify = $this->get('notification');
            $notify->addEventNotification($user, $event, 3);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Event/add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * @Route("/remove")
     */
    public function removeAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/update")
     * @Template()
     */
    public function updateAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/participate/{id}", name="add_player")
     */
    public function participateAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $eventmenager = $em->getRepository('AppBundle:Event')
                ->find($event);

        if (!$eventmenager) {
            throw $this->createNotFoundException(
                    'Nie ma takiego eventu ' . $event->getId()
            );
        }

        if ($user) {
            $eventmenager->addPlayer($user);
            $em->flush();

            $notify = $this->get('notification');
            $notify->addEventNotification($user, $event, 4);

            $this->addFlash('success', sprintf('Użytkownik "%s" został dodany do gry', $user->getUsername()));
            return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
        }
        $this->addFlash('danger', 'Musisz być zalogowany aby wpisać się do gry');
        return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
    }

    /**
     * @Route("/resign/{id}", name="resign_player")
     */
    public function resignAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $eventmenager = $em->getRepository('AppBundle:Event')
                ->find($event);

        $teams = $this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder()
                        ->select('t')
                        ->from('AppBundle:Team', 't')
                        ->join('t.event', 'e')
                        ->where('e.id = :event')
                        ->setParameter('event', $event)
                        ->getQuery()->getResult();

        foreach ($teams as $team) {
            $players = $team->getPlayers();
            foreach ($players as $player) {
                if ($user->getId() == $player->getId()) {
                    $user->removeTeam($team);
                }
            }
        }

        $eventmenager->removePlayer($this->getUser());
        $em->flush();

        $notify = $this->get('notification');
        $notify->addEventNotification($user, $event, 5);

        $this->addFlash('success', sprintf('Użytkownik "%s" został usunięty z gry', $user->getUsername()));
        return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
    }

    /**
     * @Route("/show/{category}", name="events_category_list")
     */
    public function showAction(Request $request, Category $category)
    {
        $events = $this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder()
                        ->select('e', 'p')
                        ->from('AppBundle:Event', 'e')
                        ->innerJoin('e.players', 'p')
                        ->where('e.category = :category')
                        ->setParameter('category', $category)
                        ->orderBy('e.startDate', 'DESC')
                        ->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $events, $request->query->get('page', 1), 8
        );

        return $this->render('Event/show.html.twig', [
                    'events' => $pagination,
        ]);
    }

    /**
     * @Route("/show/event/{id}", name="show_event")
     */
    public function showEventAction(Event $event, Request $request)
    {
        $findEvent = $this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder()
                        ->select('e', 'p')
                        ->from('AppBundle:Event', 'e')
                        ->innerJoin('e.players', 'p')
                        ->where('e.id = :id')
                        ->setParameter('id', $event)
                        ->getQuery()->getResult();

        $messages = $this->getDoctrine()
                        ->getManager()
                        ->createQueryBuilder()
                        ->select('m', 'e', 'c')
                        ->from('AppBundle:Message', 'm')
                        ->innerJoin('m.event', 'e')
                        ->innerJoin('m.createdBy', 'c')
                        ->where('m.event = :event')
                        ->setParameter('event', $event)
                        ->orderBy('m.createdAt', 'ASC')
                        ->getQuery()->getResult();

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $message = new Message();

        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $message->setCreatedBy($user);
            $message->setCreatedAt(new \DateTime());
            $message->setEvent($event);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('show_event', ['id' => $event->getId()]);
        }

        return $this->render('Event/showEvent.html.twig', [
                    'event' => $findEvent,
                    'messages' => $messages,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/events/{id}", name="show_user_events")
     */
    public function showUserEventsAction(User $user, Request $request)
    {

        $events = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder()
                ->select('e', 'p')
                ->from('AppBundle:Event', 'e')
                ->leftJoin('e.players', 'p')
                ->where('p.id = :id')
                ->setParameter('id', $user->getId())
                ->getQuery()
                ->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $events, $request->query->get('page', 1), 8
        );

        return $this->render('Event/show.html.twig', [
                    'events' => $pagination,
        ]);
    }

}
