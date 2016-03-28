<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @Vich\Uploadable
 */
class Team
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
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Score", mappedBy="team")
     */
    private $scores;

    public function __toString()
    {
        return $this->name;
    }

    /**
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="team")
     */
    private $players;

    /**
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="myTeam")
     */
    private $teamAdmin;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="team")
     */
    private $notifications;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="team")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="teams")
     */
    private $event;

    /**
     * * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="team_image", fileNameProperty="imageName")
     * @var File $imageFile
     */
    private $imageFile;

    /**
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     *
     * @var string $imageName
     */
    private $imageName;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teamAdmin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Team
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
     * Set type
     *
     * @param integer $type
     * @return Team
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Team
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Add scores
     *
     * @param \AppBundle\Entity\Score $scores
     * @return Team
     */
    public function addScore(\AppBundle\Entity\Score $scores)
    {
        $this->scores[] = $scores;

        return $this;
    }

    /**
     * Remove scores
     *
     * @param \AppBundle\Entity\Score $scores
     */
    public function removeScore(\AppBundle\Entity\Score $scores)
    {
        $this->scores->removeElement($scores);
    }

    /**
     * Get scores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Add players
     *
     * @param \AppBundle\Entity\User $players
     * @return Team
     */
    public function addPlayer(\AppBundle\Entity\User $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \AppBundle\Entity\User $players
     */
    public function removePlayer(\AppBundle\Entity\User $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Add teamAdmin
     *
     * @param \AppBundle\Entity\User $teamAdmin
     * @return Team
     */
    public function addTeamAdmin(\AppBundle\Entity\User $teamAdmin)
    {
        $this->teamAdmin[] = $teamAdmin;

        return $this;
    }

    /**
     * Remove teamAdmin
     *
     * @param \AppBundle\Entity\User $teamAdmin
     */
    public function removeTeamAdmin(\AppBundle\Entity\User $teamAdmin)
    {
        $this->teamAdmin->removeElement($teamAdmin);
    }

    /**
     * Get teamAdmin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeamAdmin()
    {
        return $this->teamAdmin;
    }

    /**
     * Add notifications
     *
     * @param \AppBundle\Entity\Notification $notifications
     * @return Team
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
     * Add event
     *
     * @param \AppBundle\Entity\Event $event
     * @return Team
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Team
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
