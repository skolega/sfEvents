<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlaceReservation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceReservationRepository")
 */
class PlaceReservation
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
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;
    
    /**
     *
     * @ORM\Column(name="repeatable", type="boolean")
     */
    private $repeatable;
    
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="reservation")
     */
    private $place;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reservation")
     */
    private $reservedBy;


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
     * Set data
     *
     * @param \DateTime $data
     * @return PlaceReservation
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return PlaceReservation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set repeatable
     *
     * @param boolean $repeatable
     * @return PlaceReservation
     */
    public function setRepeatable($repeatable)
    {
        $this->repeatable = $repeatable;

        return $this;
    }

    /**
     * Get repetable
     *
     * @return boolean 
     */
    public function getRepeatable()
    {
        return $this->repeatable;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return PlaceReservation
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
     * Set place
     *
     * @param \AppBundle\Entity\Place $place
     * @return PlaceReservation
     */
    public function setPlace(\AppBundle\Entity\Place $place = null)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return \AppBundle\Entity\Place 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set reservedBy
     *
     * @param \AppBundle\Entity\User $reservedBy
     * @return PlaceReservation
     */
    public function setReservedBy(\AppBundle\Entity\User $reservedBy = null)
    {
        $this->reservedBy = $reservedBy;

        return $this;
    }

    /**
     * Get reservedBy
     *
     * @return \AppBundle\Entity\User 
     */
    public function getReservedBy()
    {
        return $this->reservedBy;
    }
}
