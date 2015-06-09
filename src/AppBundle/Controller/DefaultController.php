<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $qb = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder();

        $events = $qb->select('e', 'u')
                        ->from('AppBundle:Event', 'e')
                        ->innerJoin('e.players', 'u')
                        ->orderBy('e.startDate', 'DESC')
                        ->getQuery()->getResult();

        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('default/index.html.twig', [
                    'events' => $events,
                    'categories' => $categories,
        ]);
    }

    /**
     * @Route("/badge", name="notification_badge")
     */
    public function notificationBadgeAction()
    {
        $user = $this->getUser();
        $myEvents = $user->getEvents();
        $myFriends = $user->getMyFriends();

        $notifications = $this->getDoctrine()
                ->getRepository('AppBundle:Notification')
                ->getNotifications($myFriends, $myEvents, $user);
        
        return $this->render('default/notificationBadge.html.twig', [
                    'notifications' => $notifications,
        ]);
    }
    
    /**
     * @Route("/messagebadge", name="message_badge")
     */
    public function messageBadgeAction()
    {
     $user = $this->getUser();

        $messages = $this->getDoctrine()
                ->getRepository('AppBundle:PrivateMessage')
                ->getNotReadedMessages($user);

        return $this->render('default/messageBadge.html.twig', [
                    'messages' => $messages,
        ]);
    }
}
