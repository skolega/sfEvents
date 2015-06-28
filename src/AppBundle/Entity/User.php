<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\User;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="players")
     * 
     *
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="Place", mappedBy="admin")
     */
    private $places;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Team", inversedBy="players")
     */
    private $team;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="admin")
     * @JoinTable(name="admin_event")
     */
    private $own_events;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="my_id")
     */
    private $hidden_friends;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="hidden_friends")
     */
    private $my_id;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="hide_to_user")
     * @JoinTable(name="hidden_notifications")
     */
    private $hidden_notification;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="user")
     * 
     */
    private $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", inversedBy="friend")
     * @JoinTable(name="friends_notifications")
     */
    private $friendNotifications;

    /**
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName")
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
     * @ORM\OneToMany(targetEntity="PrivateMessage", mappedBy="sendTo")
     */
    private $recieved_private_messages;

    /**
     * @ORM\OneToMany(targetEntity="PrivateMessage", mappedBy="createdBy")
     */
    private $created_private_messages;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="createdBy")
     */
    private $created_messages;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="myFriends")
     * */
    private $friendsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
     * @JoinTable(name="friends",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="friend_user_id", referencedColumnName="id")}
     *      )
     * */
    private $myFriends;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @ORM\Column(name="preferedCity", type="string", length=255, nullable=true)
     */
    private $preferedCity;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     */
    protected $facebookAccessToken;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="PlaceReservation", mappedBy="reservedBy")
     */
    private $reservations;

    public function __construct()
    {
        parent::__construct();
        $this->friendsWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myFriends = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        parent::__toString();
        return $this->username;
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
     * Add events
     *
     * @param \AppBundle\Entity\Event $events
     * @return User
     */
    public function addEvent(\AppBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \AppBundle\Entity\Event $events
     */
    public function removeEvent(\AppBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add own_events
     *
     * @param \AppBundle\Entity\Event $ownEvents
     * @return User
     */
    public function addOwnEvent(\AppBundle\Entity\Event $ownEvents)
    {
        $this->own_events[] = $ownEvents;

        return $this;
    }

    /**
     * Remove own_events
     *
     * @param \AppBundle\Entity\Event $ownEvents
     */
    public function removeOwnEvent(\AppBundle\Entity\Event $ownEvents)
    {
        $this->own_events->removeElement($ownEvents);
    }

    /**
     * Get own_events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwnEvents()
    {
        return $this->own_events;
    }

    /**
     * Set own_events
     *
     * @param \AppBundle\Entity\Event $ownEvents
     * @return User
     */
    public function setOwnEvents(\AppBundle\Entity\Event $ownEvents = null)
    {
        $this->own_events = $ownEvents;

        return $this;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Add messages
     *
     * @param \AppBundle\Entity\Message $messages
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \AppBundle\Entity\Message $messages
     */
    public function removeMessage(\AppBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add team
     *
     * @param \AppBundle\Entity\Team $team
     * @return User
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
     * Add friendsWithMe
     *
     * @param \AppBundle\Entity\User $friendsWithMe
     * @return User
     */
    public function addFriendsWithMe(\AppBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \AppBundle\Entity\User $friendsWithMe
     */
    public function removeFriendsWithMe(\AppBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add myFriends
     *
     * @param \AppBundle\Entity\User $myFriends
     * @return User
     */
    public function addMyFriend(\AppBundle\Entity\User $myFriends)
    {
        $this->myFriends[] = $myFriends;

        return $this;
    }

    /**
     * Remove myFriends
     *
     * @param \AppBundle\Entity\User $myFriends
     */
    public function removeMyFriend(\AppBundle\Entity\User $myFriends)
    {
        $this->myFriends->removeElement($myFriends);
    }

    /**
     * Get myFriends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyFriends()
    {
        return $this->myFriends;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

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
     * Set preferedCity
     *
     * @param string $preferedCity
     * @return User
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
     * Add hidden_friends
     *
     * @param \AppBundle\Entity\User $hiddenFriends
     * @return User
     */
    public function addHiddenFriend(\AppBundle\Entity\User $hiddenFriends)
    {
        $this->hidden_friends[] = $hiddenFriends;

        return $this;
    }

    /**
     * Remove hidden_friends
     *
     * @param \AppBundle\Entity\User $hiddenFriends
     */
    public function removeHiddenFriend(\AppBundle\Entity\User $hiddenFriends)
    {
        $this->hidden_friends->removeElement($hiddenFriends);
    }

    /**
     * Get hidden_friends
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHiddenFriends()
    {
        return $this->hidden_friends;
    }

    /**
     * Add my_id
     *
     * @param \AppBundle\Entity\User $myId
     * @return User
     */
    public function addMyId(\AppBundle\Entity\User $myId)
    {
        $this->my_id[] = $myId;

        return $this;
    }

    /**
     * Remove my_id
     *
     * @param \AppBundle\Entity\User $myId
     */
    public function removeMyId(\AppBundle\Entity\User $myId)
    {
        $this->my_id->removeElement($myId);
    }

    /**
     * Get my_id
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyId()
    {
        return $this->my_id;
    }

    /**
     * Add notifications
     *
     * @param \AppBundle\Entity\Notification $notifications
     * @return User
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
     * Add friendNotifications
     *
     * @param \AppBundle\Entity\Notification $friendNotifications
     * @return User
     */
    public function addFriendNotification(\AppBundle\Entity\Notification $friendNotifications)
    {
        $this->friendNotifications[] = $friendNotifications;

        return $this;
    }

    /**
     * Remove friendNotifications
     *
     * @param \AppBundle\Entity\Notification $friendNotifications
     */
    public function removeFriendNotification(\AppBundle\Entity\Notification $friendNotifications)
    {
        $this->friendNotifications->removeElement($friendNotifications);
    }

    /**
     * Get friendNotifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFriendNotifications()
    {
        return $this->friendNotifications;
    }

    /**
     * Add hidden_notification
     *
     * @param \AppBundle\Entity\Notification $hiddenNotification
     * @return User
     */
    public function addHiddenNotification(\AppBundle\Entity\Notification $hiddenNotification)
    {
        $this->hidden_notification[] = $hiddenNotification;

        return $this;
    }

    /**
     * Remove hidden_notification
     *
     * @param \AppBundle\Entity\Notification $hiddenNotification
     */
    public function removeHiddenNotification(\AppBundle\Entity\Notification $hiddenNotification)
    {
        $this->hidden_notification->removeElement($hiddenNotification);
    }

    /**
     * Get hidden_notification
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHiddenNotification()
    {
        return $this->hidden_notification;
    }

    /**
     * Add recieved_messages
     *
     * @param \AppBundle\Entity\User $recievedMessages
     * @return User
     */
    public function addRecievedMessage(\AppBundle\Entity\User $recievedMessages)
    {
        $this->recieved_messages[] = $recievedMessages;

        return $this;
    }

    /**
     * Remove recieved_messages
     *
     * @param \AppBundle\Entity\User $recievedMessages
     */
    public function removeRecievedMessage(\AppBundle\Entity\User $recievedMessages)
    {
        $this->recieved_messages->removeElement($recievedMessages);
    }

    /**
     * Get recieved_messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecievedMessages()
    {
        return $this->recieved_messages;
    }

    /**
     * Add created_messages
     *
     * @param \AppBundle\Entity\Message $createdMessages
     * @return User
     */
    public function addCreatedMessage(\AppBundle\Entity\Message $createdMessages)
    {
        $this->created_messages[] = $createdMessages;

        return $this;
    }

    /**
     * Remove created_messages
     *
     * @param \AppBundle\Entity\Message $createdMessages
     */
    public function removeCreatedMessage(\AppBundle\Entity\Message $createdMessages)
    {
        $this->created_messages->removeElement($createdMessages);
    }

    /**
     * Get created_messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedMessages()
    {
        return $this->created_messages;
    }

    /**
     * Add recieved_private_messages
     *
     * @param \AppBundle\Entity\PrivateMessage $recievedPrivateMessages
     * @return User
     */
    public function addRecievedPrivateMessage(\AppBundle\Entity\PrivateMessage $recievedPrivateMessages)
    {
        $this->recieved_private_messages[] = $recievedPrivateMessages;

        return $this;
    }

    /**
     * Remove recieved_private_messages
     *
     * @param \AppBundle\Entity\PrivateMessage $recievedPrivateMessages
     */
    public function removeRecievedPrivateMessage(\AppBundle\Entity\PrivateMessage $recievedPrivateMessages)
    {
        $this->recieved_private_messages->removeElement($recievedPrivateMessages);
    }

    /**
     * Get recieved_private_messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecievedPrivateMessages()
    {
        return $this->recieved_private_messages;
    }

    /**
     * Add created_private_messages
     *
     * @param \AppBundle\Entity\PrivateMessage $createdPrivateMessages
     * @return User
     */
    public function addCreatedPrivateMessage(\AppBundle\Entity\PrivateMessage $createdPrivateMessages)
    {
        $this->created_private_messages[] = $createdPrivateMessages;

        return $this;
    }

    /**
     * Remove created_private_messages
     *
     * @param \AppBundle\Entity\PrivateMessage $createdPrivateMessages
     */
    public function removeCreatedPrivateMessage(\AppBundle\Entity\PrivateMessage $createdPrivateMessages)
    {
        $this->created_private_messages->removeElement($createdPrivateMessages);
    }

    /**
     * Get created_private_messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedPrivateMessages()
    {
        return $this->created_private_messages;
    }


    /**
     * Add places
     *
     * @param \AppBundle\Entity\Place $places
     * @return User
     */
    public function addPlace(\AppBundle\Entity\Place $places)
    {
        $this->places[] = $places;

        return $this;
    }

    /**
     * Remove places
     *
     * @param \AppBundle\Entity\Place $places
     */
    public function removePlace(\AppBundle\Entity\Place $places)
    {
        $this->places->removeElement($places);
    }

    /**
     * Get places
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlaces()
    {
        return $this->places;
    }

    /**
     * Add reservations
     *
     * @param \AppBundle\Entity\PlaceReservation $reservations
     * @return User
     */
    public function addReservation(\AppBundle\Entity\PlaceReservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \AppBundle\Entity\PlaceReservation $reservations
     */
    public function removeReservation(\AppBundle\Entity\PlaceReservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
