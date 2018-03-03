<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * Province
 */
class Province
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $communes;

    /**
     * @var \FotoJoin\AdminBundle\Entity\Region
     */
    private $region;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->communes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Province
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
     * Add commune
     *
     * @param \FotoJoin\AdminBundle\Entity\Commune $commune
     *
     * @return Province
     */
    public function addCommune(\FotoJoin\AdminBundle\Entity\Commune $commune)
    {
        $this->communes[] = $commune;

        return $this;
    }

    /**
     * Remove commune
     *
     * @param \FotoJoin\AdminBundle\Entity\Commune $commune
     */
    public function removeCommune(\FotoJoin\AdminBundle\Entity\Commune $commune)
    {
        $this->communes->removeElement($commune);
    }

    /**
     * Get communes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommunes()
    {
        return $this->communes;
    }

    /**
     * Set region
     *
     * @param \FotoJoin\AdminBundle\Entity\Region $region
     *
     * @return Province
     */
    public function setRegion(\FotoJoin\AdminBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \FotoJoin\AdminBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }
}

