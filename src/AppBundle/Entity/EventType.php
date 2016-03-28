<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EventType
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payable", type="boolean")
     */
    private $payable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="teamable", type="boolean")
     */
    private $teamable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="twoTeams", type="boolean")
     */
    private $twoTeams;

    /**
     * @var boolean
     *
     * @ORM\Column(name="playable", type="boolean")
     */
    private $playable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Event", mappedBy="eventType")
     *
     */
    private $event;
    
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
     * Set name
     *
     * @param string $name
     * @return EventType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EventType
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set payable
     *
     * @param boolean $payable
     * @return EventType
     */
    public function setPayable($payable)
    {
        $this->payable = $payable;

        return $this;
    }

    /**
     * Get payable
     *
     * @return boolean 
     */
    public function getPayable()
    {
        return $this->payable;
    }

    /**
     * Set teamable
     *
     * @param boolean $teamable
     * @return EventType
     */
    public function setTeamable($teamable)
    {
        $this->teamable = $teamable;

        return $this;
    }

    /**
     * Get teamable
     *
     * @return boolean 
     */
    public function getTeamable()
    {
        return $this->teamable;
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return EventType
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean 
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set playable
     *
     * @param boolean $playable
     * @return EventType
     */
    public function setPlayable($playable)
    {
        $this->playable = $playable;

        return $this;
    }

    /**
     * Get playable
     *
     * @return boolean 
     */
    public function getPlayable()
    {
        return $this->playable;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return EventType
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
     * Set eventType
     *
     * @param \AppBundle\Entity\Event $eventType
     * @return EventType
     */
    public function setEventType(\AppBundle\Entity\Event $eventType = null)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return \AppBundle\Entity\Event 
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set twoTeams
     *
     * @param boolean $twoTeams
     * @return EventType
     */
    public function setTwoTeams($twoTeams)
    {
        $this->twoTeams = $twoTeams;

        return $this;
    }

    /**
     * Get twoTeams
     *
     * @return boolean 
     */
    public function getTwoTeams()
    {
        return $this->twoTeams;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     * @return EventType
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
}
