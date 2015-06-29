<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class NotificationController extends Controller
{

    /**
     * @Route("/index/notifications", name="index_notification")
     */
    public function indexAction()
    {
        $user = $this->getUser();
         $myEvents = $user->getEvents();
        $myFriends = $user->getMyFriends();

        $notifications = $this->getDoctrine()
                ->getRepository('AppBundle:Notification')
                ->getAllNotifications($myFriends, $myEvents, $user, false);



        return $this->render('Notification/index.html.twig', [
                    'notifications' => $notifications,
        ]);
    }

    /**
     * @Route("/hide/notification", name="hide_notifications")
     */
    public function hideAction()
    {
        $user = $this->getUser();
        $myEvents = $user->getEvents();
        $myFriends = $user->getMyFriends();

        $notifications = $this->getDoctrine()
                ->getRepository('AppBundle:Notification')
                ->getNotifications($myFriends, $myEvents, $user);

        $em = $this->getDoctrine()->getManager();
        foreach ($notifications as $notification) {
            $user->addHiddenNotification($notification);
        }
        $em->flush();

        return $this;
    }

    /**
     * @Route("/remove/notification")
     * @Template()
     */
    public function removeAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/show/notification")
     */
    public function showAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/list/notifications/{user}", name="notification_list")
     */
    public function listAction(User $user)
    {
        $myEvents = $user->getEvents();
        $myFriends = $user->getMyFriends();

        $notifications = $this->getDoctrine()
                ->getRepository('AppBundle:Notification')
                ->getAllNotifications($myFriends, $myEvents, $user, true);



        return $this->render('Notification/list.html.twig', [
                    'notifications' => $notifications,
        ]);
    }
    
    /**
     * @Route("/list/place_notifications/{user}", name="place_notification_list")
     */
    public function placeListAction(User $user)
    {
        $myPlaces = $user->getPlaces();
        $myFriends = $user->getMyFriends();

        $notifications = $this->getDoctrine()
                ->getRepository('AppBundle:Notification')
                ->getAllNotifications($myFriends, $myPlaces, $user, true);



        return $this->render('Notification/list.html.twig', [
                    'notifications' => $notifications,
        ]);
    }

    private function getRefererParams()
    {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
        return $this->get('router')->getMatcher()->match($lastPath);
    }

    public function handleRequestAction()
    {

        $request = $this->get('request');
    }

}
