<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="private_message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrivateMessageRepository")
 */
class PrivateMessage
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
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recieved_private_messages")
     */
    private $sendTo;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="created_private_message")
     */
    private $createdBy;
    
    
    /**
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed = false;

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
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdBy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     * @return Message
     */
    public function addCreatedBy(\AppBundle\Entity\User $createdBy)
    {
        $this->createdBy[] = $createdBy;

        return $this;
    }

    /**
     * Remove createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     */
    public function removeCreatedBy(\AppBundle\Entity\User $createdBy)
    {
        $this->createdBy->removeElement($createdBy);
    }

    /**
     * Get createdBy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     * @return Message
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     * @return Message
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Add notifications
     *
     * @param \AppBundle\Entity\Notification $notifications
     * @return Message
     */
    public function addNotification(\AppBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \AppBundle\Entity\Notification $notifications
     */
    public function removeNotification(\AppBundle\Entity\Notification $notifications)
    {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set sendTo
     *
     * @param \AppBundle\Entity\User $sendTo
     * @return Message
     */
    public function setSendTo(\AppBundle\Entity\User $sendTo = null)
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Get sendTo
     *
     * @return \AppBundle\Entity\User 
     */
    public function getSendTo()
    {
        return $this->sendTo;
    }

    /**
     * Set readed
     *
     * @param boolean $readed
     * @return PrivateMessage
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return boolean 
     */
    public function getReaded()
    {
        return $this->readed;
    }
}
