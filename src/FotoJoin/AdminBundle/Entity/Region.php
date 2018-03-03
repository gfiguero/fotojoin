<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * Region
 */
class Region
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
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $provinces;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provinces = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Region
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
     * Set code
     *
     * @param string $code
     *
     * @return Region
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Region
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
     * Add province
     *
     * @param \FotoJoin\AdminBundle\Entity\Province $province
     *
     * @return Region
     */
    public function addProvince(\FotoJoin\AdminBundle\Entity\Province $province)
    {
        $this->provinces[] = $province;

        return $this;
    }

    /**
     * Remove province
     *
     * @param \FotoJoin\AdminBundle\Entity\Province $province
     */
    public function removeProvince(\FotoJoin\AdminBundle\Entity\Province $province)
    {
        $this->provinces->removeElement($province);
    }

    /**
     * Get provinces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProvinces()
    {
        return $this->provinces;
    }
}

