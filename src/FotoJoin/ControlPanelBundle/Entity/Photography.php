<?php

namespace FotoJoin\ControlPanelBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Photography
 * @Vich\Uploadable
 */
class Photography
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var File $file
     * @Vich\UploadableField(mapping="photography", fileNameProperty="filename")
     */
    private $file;

    /**
     * @var string
     */
    private $filename;

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

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $MakeModel;

    /**
     * @var \DateTime
     */
    private $DateTimeOriginal;

    /**
     * @var string
     */
    private $ExposureTime;

    /**
     * @var integer
     */
    private $FocalLength;

    /**
     * @var string
     */
    private $FNumber;

    /**
     * @var integer
     */
    private $ISOSpeedRatings;

    /**
     * @var \FotoJoin\UserBundle\Entity\Author
     */
    private $author;

    /**
     * @var \FotoJoin\ControlPanelBundle\Entity\Album
     */
    private $album;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->filename;
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
     * Set filename
     *
     * @param string $filename
     *
     * @return Photography
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set file
     *
     * @param \File $file
     * @return Photography
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
        if ($file) { $this->updatedAt = new \DateTime('now'); }
        return $this;
    }
    /**
     * Get file
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Photography
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
     * @return Photography
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
     * @return Photography
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
     * Set author
     *
     * @param \FotoJoin\UserBundle\Entity\Author $author
     *
     * @return Photography
     */
    public function setAuthor(\FotoJoin\UserBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \FotoJoin\UserBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function setCategory(\FotoJoin\AdminBundle\Entity\Category $category)
    {
        return $this->addCategory($category);
    }

    /**
     * Add category
     *
     * @param \FotoJoin\AdminBundle\Entity\Category $category
     *
     * @return Photography
     */
    public function addCategory(\FotoJoin\AdminBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \FotoJoin\AdminBundle\Entity\Category $category
     */
    public function removeCategory(\FotoJoin\AdminBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Photography
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set album
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Album $album
     *
     * @return Photography
     */
    public function setAlbum(\FotoJoin\ControlPanelBundle\Entity\Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \FotoJoin\ControlPanelBundle\Entity\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Set makeModel
     *
     * @param string $makeModel
     *
     * @return Photography
     */
    public function setMakeModel($makeModel)
    {
        $this->MakeModel = $makeModel;

        return $this;
    }

    /**
     * Get makeModel
     *
     * @return string
     */
    public function getMakeModel()
    {
        return $this->MakeModel;
    }

    /**
     * Set dateTimeOriginal
     *
     * @param \DateTime $dateTimeOriginal
     *
     * @return Photography
     */
    public function setDateTimeOriginal($dateTimeOriginal)
    {
        $this->DateTimeOriginal = $dateTimeOriginal;

        return $this;
    }

    /**
     * Get dateTimeOriginal
     *
     * @return \DateTime
     */
    public function getDateTimeOriginal()
    {
        return $this->DateTimeOriginal;
    }

    /**
     * Set exposureTime
     *
     * @param string $exposureTime
     *
     * @return Photography
     */
    public function setExposureTime($exposureTime)
    {
        $this->ExposureTime = $exposureTime;

        return $this;
    }

    /**
     * Get exposureTime
     *
     * @return string
     */
    public function getExposureTime()
    {
        return $this->ExposureTime;
    }

    /**
     * Set iSOSpeedRatings
     *
     * @param integer $iSOSpeedRatings
     *
     * @return Photography
     */
    public function setISOSpeedRatings($iSOSpeedRatings)
    {
        $this->ISOSpeedRatings = $iSOSpeedRatings;

        return $this;
    }

    /**
     * Get iSOSpeedRatings
     *
     * @return integer
     */
    public function getISOSpeedRatings()
    {
        return $this->ISOSpeedRatings;
    }
    /**
     * Set FocalLength
     *
     * @param integer $FocalLength
     *
     * @return Photography
     */
    public function setFocalLength($FocalLength)
    {
        $this->FocalLength = $FocalLength;

        return $this;
    }

    /**
     * Get FocalLength
     *
     * @return integer
     */
    public function getFocalLength()
    {
        return $this->FocalLength;
    }

    /**
     * Set FNumber
     *
     * @param integer $FNumber
     *
     * @return Photography
     */
    public function setFNumber($FNumber)
    {
        $this->FNumber = $FNumber;

        return $this;
    }

    /**
     * Get FNumber
     *
     * @return integer
     */
    public function getFNumber()
    {
        return $this->FNumber;
    }

    /**
     * Set exif
     *
     * @param string $exif
     *
     * @return Photography
     */
    public function setExif($exif)
    {
        if(array_key_exists('Make', $exif) && array_key_exists('Model', $exif)) $this->setMakeModel($exif['Make'].' - '.$exif['Model']);
        if(array_key_exists('DateTimeOriginal', $exif)) $this->setDateTimeOriginal(new \DateTime($exif['DateTimeOriginal']));
        if(array_key_exists('ExposureTime', $exif)) $this->setExposureTime($exif['ExposureTime']);
        if(array_key_exists('FocalLength', $exif)) $this->setFocalLength($exif['FocalLength']);
        if(array_key_exists('FNumber', $exif)) {
            $fNumber = explode('/',$exif['FNumber']);
            $this->setFNumber($fNumber[0]/$fNumber[1]);
        }
        if(array_key_exists('ISOSpeedRatings', $exif)) $this->setISOSpeedRatings($exif['ISOSpeedRatings']);

        return $this;
    }

    /**
     * @var boolean
     */
    private $published = false;


    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Photography
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }
    /**
     * @var \FotoJoin\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \FotoJoin\UserBundle\Entity\User $user
     *
     * @return Photography
     */
    public function setUser(\FotoJoin\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FotoJoin\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $appraisements;


    /**
     * Add appraisement
     *
     * @param \FotoJoin\GalleryBundle\Entity\Appraisement $appraisement
     *
     * @return Photography
     */
    public function addAppraisement(\FotoJoin\GalleryBundle\Entity\Appraisement $appraisement)
    {
        $this->appraisements[] = $appraisement;

        return $this;
    }

    /**
     * Remove appraisement
     *
     * @param \FotoJoin\GalleryBundle\Entity\Appraisement $appraisement
     */
    public function removeAppraisement(\FotoJoin\GalleryBundle\Entity\Appraisement $appraisement)
    {
        $this->appraisements->removeElement($appraisement);
    }

    /**
     * Get appraisements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppraisements()
    {
        return $this->appraisements;
    }

    /**
     * Get appraisement
     */
    public function getAppraisement()
    {
        $sum = 0;
        $appraisements = $this->getAppraisements();
        foreach ($appraisements as $appraisement) {
            dump($appraisement);
            $sum += $appraisement->getValue();
        }

        $count = $appraisements->count();
        if ($count) {
            return $sum / $count;
        } else {
            return 0;
        }

    }

}
