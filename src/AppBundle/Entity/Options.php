<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Options
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
     * @ORM\Column(name="preferedCity", type="string", length=255)
     */
    private $preferedCity;

    /**
     * @var string
     *
     * @ORM\Column(name="preferedCategory", type="string", length=255)
     */
    private $preferedCategory;

    /**
     * @var boolean
     *
     * @ORM\Column(name="notifications", type="boolean")
     */
    private $notifications;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="messages", type="boolean")
     */
    private $messages;

    /**
     * @var boolean
     *
     * @ORM\Column(name="invitations", type="boolean")
     */
    private $invitations;


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
     * Set preferedCity
     *
     * @param string $preferedCity
     * @return Options
     */
    public function setPreferedCity($preferedCity)
    {
        $this->preferedCity = $preferedCity;

        return $this;
    }

    /**
     * Get preferedCity
     *
     * @return string 
     */
    public function getPreferedCity()
    {
        return $this->preferedCity;
    }

    /**
     * Set preferedCategory
     *
     * @param string $preferedCategory
     * @return Options
     */
    public function setPreferedCategory($preferedCategory)
    {
        $this->preferedCategory = $preferedCategory;

        return $this;
    }

    /**
     * Get preferedCategory
     *
     * @return string 
     */
    public function getPreferedCategory()
    {
        return $this->preferedCategory;
    }

    /**
     * Set notifications
     *
     * @param boolean $notifications
     * @return Options
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * Get notifications
     *
     * @return boolean 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Options
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set messages
     *
     * @param boolean $messages
     * @return Options
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages
     *
     * @return boolean 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set invitations
     *
     * @param boolean $invitations
     * @return Options
     */
    public function setInvitations($invitations)
    {
        $this->invitations = $invitations;

        return $this;
    }

    /**
     * Get invitations
     *
     * @return boolean 
     */
    public function getInvitations()
    {
        return $this->invitations;
    }
}
