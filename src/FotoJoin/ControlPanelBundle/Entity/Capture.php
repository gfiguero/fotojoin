<?php

namespace FotoJoin\ControlPanelBundle\Entity;

/**
 * Capture
 */
class Capture
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $lens;

    /**
     * @var string
     */
    private $sensibility;

    /**
     * @var string
     */
    private $aperture;

    /**
     * @var string
     */
    private $shutter;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Capture
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Capture
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set lens
     *
     * @param string $lens
     *
     * @return Capture
     */
    public function setLens($lens)
    {
        $this->lens = $lens;

        return $this;
    }

    /**
     * Get lens
     *
     * @return string
     */
    public function getLens()
    {
        return $this->lens;
    }

    /**
     * Set sensibility
     *
     * @param string $sensibility
     *
     * @return Capture
     */
    public function setSensibility($sensibility)
    {
        $this->sensibility = $sensibility;

        return $this;
    }

    /**
     * Get sensibility
     *
     * @return string
     */
    public function getSensibility()
    {
        return $this->sensibility;
    }

    /**
     * Set aperture
     *
     * @param string $aperture
     *
     * @return Capture
     */
    public function setAperture($aperture)
    {
        $this->aperture = $aperture;

        return $this;
    }

    /**
     * Get aperture
     *
     * @return string
     */
    public function getAperture()
    {
        return $this->aperture;
    }

    /**
     * Set shutter
     *
     * @param string $shutter
     *
     * @return Capture
     */
    public function setShutter($shutter)
    {
        $this->shutter = $shutter;

        return $this;
    }

    /**
     * Get shutter
     *
     * @return string
     */
    public function getShutter()
    {
        return $this->shutter;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Capture
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
     * @return Capture
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
     * @return Capture
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
}
