<?php

namespace AppBundle\Service;

use AppBundle\Entity\Notification;
use Doctrine\ORM\EntityManager;

/**
 * Description of Basket
 */
class Notifications
{

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function addEventNotification($user, $event, $type)
    {

        $notification = new Notification();

        $user->addNotification($notification);
        $event->addNotification($notification);
        $notification->setType($type);
        
        $this->em->persist($notification);
        $this->em->flush();

        return $this;
    }
    
    public function addUserNotification($user, $type)
    {

        $notification = new Notification();

        $user->addNotification($notification);
        $notification->setType($type);
        
        $this->em->persist($notification);
        $this->em->flush();

        return $this;
    }

    public function addTeamNotification($user, $event, $team, $type)
    {

        $notification = new Notification();

        $notification->addUser($user);
        $notification->addEvent($event);
        $notification->setType($team);
        $notification->setType($type);
        $this->em->persist($notification);
        $this->em->flush();

        return $this;
    }
    
    public function addPlaceNotification($user, $place, $type)
    {

        $notification = new Notification();

        $notification->addUser($user);
        $notification->addPlace($place);
        $notification->setType($type);
        $this->em->persist($notification);
        $this->em->flush();

        return $this;
    }

}
