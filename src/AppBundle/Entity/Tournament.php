<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tournament
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
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured;

    /**
     * @var integer
     *
     * @ORM\Column(name="teamsQuantity", type="smallint")
     */
    private $teamsQuantity;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payable", type="boolean")
     */
    private $payable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="siginEndDate", type="datetime")
     */
    private $siginEndDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * @return Tournament
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Tournament
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Tournament
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
     * Set featured
     *
     * @param boolean $featured
     * @return Tournament
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set teamsQuantity
     *
     * @param integer $teamsQuantity
     * @return Tournament
     */
    public function setTeamsQuantity($teamsQuantity)
    {
        $this->teamsQuantity = $teamsQuantity;

        return $this;
    }

    /**
     * Get teamsQuantity
     *
     * @return integer 
     */
    public function getTeamsQuantity()
    {
        return $this->teamsQuantity;
    }

    /**
     * Set payable
     *
     * @param boolean $payable
     * @return Tournament
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
     * Set siginEndDate
     *
     * @param \DateTime $siginEndDate
     * @return Tournament
     */
    public function setSiginEndDate($siginEndDate)
    {
        $this->siginEndDate = $siginEndDate;

        return $this;
    }

    /**
     * Get siginEndDate
     *
     * @return \DateTime 
     */
    public function getSiginEndDate()
    {
        return $this->siginEndDate;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Tournament
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
     * Set description
     *
     * @param string $description
     * @return Tournament
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
}
