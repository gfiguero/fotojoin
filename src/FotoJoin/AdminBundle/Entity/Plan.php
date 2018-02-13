<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * Plan
 */
class Plan
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $max_album;

    /**
     * @var integer
     */
    private $max_photography;

    public function __toString()
    {
        return (string) $this->name;
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
     *
     * @return Plan
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
     * Set maxAlbum
     *
     * @param integer $maxAlbum
     *
     * @return Plan
     */
    public function setMaxAlbum($maxAlbum)
    {
        $this->max_album = $maxAlbum;

        return $this;
    }

    /**
     * Get maxAlbum
     *
     * @return integer
     */
    public function getMaxAlbum()
    {
        return $this->max_album;
    }

    /**
     * Set maxPhotography
     *
     * @param integer $maxPhotography
     *
     * @return Plan
     */
    public function setMaxPhotography($maxPhotography)
    {
        $this->max_photography = $maxPhotography;

        return $this;
    }

    /**
     * Get maxPhotography
     *
     * @return integer
     */
    public function getMaxPhotography()
    {
        return $this->max_photography;
    }
}

