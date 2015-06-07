<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="notifications")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="notifications")
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="friendsNotifications")
     */
    private $friend;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="hidden_notification")
     */
    private $hide_to_user;

    /**
     * @ORM\ManyToMany(targetEntity="Team", mappedBy="notifications")
     */
    private $team;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Notification
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
        $this->friend = new \Doctrine\Common\Collections\ArrayCollection();
        $this->team = new \Doctrine\Common\Collections\ArrayCollection();
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     * @return Notification
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     * @return Notification
     */
    public function addEvent(\AppBundle\Entity\Event $event)
    {
        $this->event[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \AppBundle\Entity\Event $event
     */
    public function removeEvent(\AppBundle\Entity\Event $event)
    {
        $this->event->removeElement($event);
    }

    /**
     * Get event
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Add friend
     *
     * @param \AppBundle\Entity\User $friend
     * @return Notification
     */
    public function addFriend(\AppBundle\Entity\User $friend)
    {
        $this->friend[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \AppBundle\Entity\User $friend
     */
    public function removeFriend(\AppBundle\Entity\User $friend)
    {
        $this->friend->removeElement($friend);
    }

    /**
     * Get friend
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * Add team
     *
     * @param \AppBundle\Entity\Team $team
     * @return Notification
     */
    public function addTeam(\AppBundle\Entity\Team $team)
    {
        $this->team[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \AppBundle\Entity\Team $team
     */
    public function removeTeam(\AppBundle\Entity\Team $team)
    {
        $this->team->removeElement($team);
    }

    /**
     * Get team
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     * @return Notification
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->message[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * Get message
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Add hide_to_user
     *
     * @param \AppBundle\Entity\User $hideToUser
     * @return Notification
     */
    public function addHideToUser(\AppBundle\Entity\User $hideToUser)
    {
        $this->hide_to_user[] = $hideToUser;

        return $this;
    }

    /**
     * Remove hide_to_user
     *
     * @param \AppBundle\Entity\User $hideToUser
     */
    public function removeHideToUser(\AppBundle\Entity\User $hideToUser)
    {
        $this->hide_to_user->removeElement($hideToUser);
    }

    /**
     * Get hide_to_user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHideToUser()
    {
        return $this->hide_to_user;
    }
}
