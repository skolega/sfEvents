<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Place
 *
 * @ORM\Table(name="places")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place
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
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_nb", type="string", length=255)
     */
    private $telephoneNb;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="places")
     */
    private $admin;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_capacity", type="integer")
     */
    private $maxCapacity;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="smallint")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="places")
     */
    private $category;
    

    /**
     * @Vich\UploadableField(mapping="place_image", fileNameProperty="imageName")
     *
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
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="place")
     */
    private $notifications;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="PlaceReservation", mappedBy="place")
     */
    private $reservation;
    
    public function __toString()
    {
        return $this->name;
    }

 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->admin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Place
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
     * Set city
     *
     * @param string $city
     * @return Place
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Place
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set telephoneNb
     *
     * @param string $telephoneNb
     * @return Place
     */
    public function setTelephoneNb($telephoneNb)
    {
        $this->telephoneNb = $telephoneNb;

        return $this;
    }

    /**
     * Get telephoneNb
     *
     * @return string 
     */
    public function getTelephoneNb()
    {
        return $this->telephoneNb;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Place
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Place
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
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     * @return Place
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime 
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set maxCapacity
     *
     * @param integer $maxCapacity
     * @return Place
     */
    public function setMaxCapacity($maxCapacity)
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    /**
     * Get maxCapacity
     *
     * @return integer 
     */
    public function getMaxCapacity()
    {
        return $this->maxCapacity;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Place
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Place
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
     * Set imageName
     *
     * @param string $imageName
     * @return Place
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Add admin
     *
     * @param \AppBundle\Entity\User $admin
     * @return Place
     */
    public function addAdmin(\AppBundle\Entity\User $admin)
    {
        $this->admin[] = $admin;

        return $this;
    }

    /**
     * Remove admin
     *
     * @param \AppBundle\Entity\User $admin
     */
    public function removeAdmin(\AppBundle\Entity\User $admin)
    {
        $this->admin->removeElement($admin);
    }

    /**
     * Get admin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Place
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\PlaceReservation $reservation
     * @return Place
     */
    public function addReservation(\AppBundle\Entity\PlaceReservation $reservation)
    {
        $this->reservation[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\PlaceReservation $reservation
     */
    public function removeReservation(\AppBundle\Entity\PlaceReservation $reservation)
    {
        $this->reservation->removeElement($reservation);
    }

    /**
     * Get reservation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Add notifications
     *
     * @param \AppBundle\Entity\Notification $notifications
     * @return Place
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
}
