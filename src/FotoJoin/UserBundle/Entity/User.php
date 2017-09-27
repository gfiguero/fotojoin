<?php

namespace FotoJoin\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $deletedAt;

    public function __toString()
    {
        return $this->name;
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
    /**
     * @var \FotoJoin\UserBundle\Entity\Author
     */
    /**
     * @var \DateTime
     */
    private $birthdate;

    /**
     * @var string
     */
    private $country;


    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @var string
     */
    private $profilephotofilename;
    /**
     * @var File $image
     * @Vich\UploadableField(mapping="profilephoto", fileNameProperty="profilephotofilename")
     */
    private $profilephoto;

    /**
     * Set profilephotofilename
     *
     * @param string $profilephotofilename
     *
     * @return User
     */
    public function setProfilePhotoFileName($profilephotofilename)
    {
        $this->profilephotofilename = $profilephotofilename;

        return $this;
    }

    /**
     * Get profilephotofilename
     *
     * @return string
     */
    public function getProfilePhotoFileName()
    {
        return $this->profilephotofilename;
    }

    public function setProfilePhoto(File $profilephoto = null)
    {
        $this->profilephoto = $profilephoto;
        if ($profilephoto) { $this->updatedAt = new \DateTime('now'); }
        return $this;
    }
    public function getProfilePhoto()
    {
        return $this->profilephoto;
    }
    /**
     * @var \FotoJoin\AdminBundle\Entity\City
     */
    private $city1;


    /**
     * Set city1
     *
     * @param \FotoJoin\AdminBundle\Entity\City $city1
     *
     * @return User
     */
    public function setCity1(\FotoJoin\AdminBundle\Entity\City $city1 = null)
    {
        $this->city1 = $city1;

        return $this;
    }

    /**
     * Get city1
     *
     * @return \FotoJoin\AdminBundle\Entity\City
     */
    public function getCity1()
    {
        return $this->city1;
    }
    /**
     * @var \FotoJoin\AdminBundle\Entity\City
     */
    private $city2;

    /**
     * @var \FotoJoin\AdminBundle\Entity\City
     */
    private $city3;


    /**
     * Set city2
     *
     * @param \FotoJoin\AdminBundle\Entity\City $city2
     *
     * @return User
     */
    public function setCity2(\FotoJoin\AdminBundle\Entity\City $city2 = null)
    {
        $this->city2 = $city2;

        return $this;
    }

    /**
     * Get city2
     *
     * @return \FotoJoin\AdminBundle\Entity\City
     */
    public function getCity2()
    {
        return $this->city2;
    }

    /**
     * Set city3
     *
     * @param \FotoJoin\AdminBundle\Entity\City $city3
     *
     * @return User
     */
    public function setCity3(\FotoJoin\AdminBundle\Entity\City $city3 = null)
    {
        $this->city3 = $city3;

        return $this;
    }

    /**
     * Get city3
     *
     * @return \FotoJoin\AdminBundle\Entity\City
     */
    public function getCity3()
    {
        return $this->city3;
    }

    public function getCities()
    {
        $cities =  array();
        if($this->city1) $cities[] = $this->city1;
        if($this->city2) $cities[] = $this->city2;
        if($this->city3) $cities[] = $this->city3;
        return $cities;
    }

    /**
     * @var string
     */
    private $facebookid;

    /**
     * @var string
     */
    private $facebookaccesstoken;


    /**
     * Set facebookid
     *
     * @param string $facebookid
     *
     * @return User
     */
    public function setFacebookid($facebookid)
    {
        $this->facebookid = $facebookid;

        return $this;
    }

    /**
     * Get facebookid
     *
     * @return string
     */
    public function getFacebookid()
    {
        return $this->facebookid;
    }

    /**
     * Set facebookaccesstoken
     *
     * @param string $facebookaccesstoken
     *
     * @return User
     */
    public function setFacebookaccesstoken($facebookaccesstoken)
    {
        $this->facebookaccesstoken = $facebookaccesstoken;

        return $this;
    }

    /**
     * Get facebookaccesstoken
     *
     * @return string
     */
    public function getFacebookaccesstoken()
    {
        return $this->facebookaccesstoken;
    }
    /**
     * @var integer
     */
    private $level;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $exigency = 4.0;


    /**
     * Set level
     *
     * @param integer $level
     *
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
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
     * Set exigency
     *
     * @param integer $exigency
     *
     * @return User
     */
    public function setExigency($exigency)
    {
        $this->exigency = $exigency;

        return $this;
    }

    /**
     * Get exigency
     *
     * @return integer
     */
    public function getExigency()
    {
        return $this->exigency;
    }
    /**
     * @var boolean
     */
    private $facebookshare = false;


    /**
     * Set facebookshare
     *
     * @param boolean $facebookshare
     *
     * @return User
     */
    public function setFacebookshare($facebookshare)
    {
        $this->facebookshare = $facebookshare;

        return $this;
    }

    /**
     * Get facebookshare
     *
     * @return boolean
     */
    public function getFacebookshare()
    {
        return $this->facebookshare;
    }
    /**
     * @var boolean
     */
    private $publiccontact = false;


    /**
     * Set publiccontact
     *
     * @param boolean $publiccontact
     *
     * @return User
     */
    public function setPubliccontact($publiccontact)
    {
        $this->publiccontact = $publiccontact;

        return $this;
    }

    /**
     * Get publiccontact
     *
     * @return boolean
     */
    public function getPubliccontact()
    {
        return $this->publiccontact;
    }
/*
    public function getAverage($categories = null)
    {
        $average = 0;
        $count = 0;
        $photographies = $this->getPhotographies();
        foreach ($photographies as $photography)
        {
            $photographyAverage = $photography->getAverage($categories);
            if ($photographyAverage)
            {
                $average += $photographyAverage;
                $count += 1;
            }
        }
        if($count) $average = $average / $count;
        return number_format((float)$average, 2, '.', '');
    }
*/

    private $average;

    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    public function getAverage()
    {
        return $this->average;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photographies;


    /**
     * Add photography
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Photography $photography
     *
     * @return User
     */
    public function addPhotography(\FotoJoin\ControlPanelBundle\Entity\Photography $photography)
    {
        $this->photographies[] = $photography;

        return $this;
    }

    /**
     * Remove photography
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Photography $photography
     */
    public function removePhotography(\FotoJoin\ControlPanelBundle\Entity\Photography $photography)
    {
        $this->photographies->removeElement($photography);
    }

    /**
     * Get photographies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotographies()
    {
        return $this->photographies;
    }
    /**
     * @var string
     */
    private $googleid;

    /**
     * @var string
     */
    private $googleaccesstoken;


    /**
     * Set googleid
     *
     * @param string $googleid
     *
     * @return User
     */
    public function setGoogleid($googleid)
    {
        $this->googleid = $googleid;

        return $this;
    }

    /**
     * Get googleid
     *
     * @return string
     */
    public function getGoogleid()
    {
        return $this->googleid;
    }

    /**
     * Set googleaccesstoken
     *
     * @param string $googleaccesstoken
     *
     * @return User
     */
    public function setGoogleaccesstoken($googleaccesstoken)
    {
        $this->googleaccesstoken = $googleaccesstoken;

        return $this;
    }

    /**
     * Get googleaccesstoken
     *
     * @return string
     */
    public function getGoogleaccesstoken()
    {
        return $this->googleaccesstoken;
    }
    /**
     * @var string
     */
    private $twitterid;

    /**
     * @var string
     */
    private $twitteraccesstoken;


    /**
     * Set twitterid
     *
     * @param string $twitterid
     *
     * @return User
     */
    public function setTwitterid($twitterid)
    {
        $this->twitterid = $twitterid;

        return $this;
    }

    /**
     * Get twitterid
     *
     * @return string
     */
    public function getTwitterid()
    {
        return $this->twitterid;
    }

    /**
     * Set twitteraccesstoken
     *
     * @param string $twitteraccesstoken
     *
     * @return User
     */
    public function setTwitteraccesstoken($twitteraccesstoken)
    {
        $this->twitteraccesstoken = $twitteraccesstoken;

        return $this;
    }

    /**
     * Get twitteraccesstoken
     *
     * @return string
     */
    public function getTwitteraccesstoken()
    {
        return $this->twitteraccesstoken;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $albums;


    /**
     * Add album
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Album $album
     *
     * @return User
     */
    public function addAlbum(\FotoJoin\ControlPanelBundle\Entity\Album $album)
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Album $album
     */
    public function removeAlbum(\FotoJoin\ControlPanelBundle\Entity\Album $album)
    {
        $this->albums->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $transmitted_messages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $received_messages;


    /**
     * Add transmittedMessage
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Message $transmittedMessage
     *
     * @return User
     */
    public function addTransmittedMessage(\FotoJoin\ControlPanelBundle\Entity\Message $transmittedMessage)
    {
        $this->transmitted_messages[] = $transmittedMessage;

        return $this;
    }

    /**
     * Remove transmittedMessage
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Message $transmittedMessage
     */
    public function removeTransmittedMessage(\FotoJoin\ControlPanelBundle\Entity\Message $transmittedMessage)
    {
        $this->transmitted_messages->removeElement($transmittedMessage);
    }

    /**
     * Get transmittedMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransmittedMessages()
    {
        return $this->transmitted_messages;
    }

    /**
     * Add receivedMessage
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Message $receivedMessage
     *
     * @return User
     */
    public function addReceivedMessage(\FotoJoin\ControlPanelBundle\Entity\Message $receivedMessage)
    {
        $this->received_messages[] = $receivedMessage;

        return $this;
    }

    /**
     * Remove receivedMessage
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Message $receivedMessage
     */
    public function removeReceivedMessage(\FotoJoin\ControlPanelBundle\Entity\Message $receivedMessage)
    {
        $this->received_messages->removeElement($receivedMessage);
    }

    /**
     * Get receivedMessages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceivedMessages()
    {
        return $this->received_messages;
    }
}
