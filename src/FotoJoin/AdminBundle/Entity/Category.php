<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * Category
 */
class Category
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
    private $photographies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photographies = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Add photography
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Photography $photography
     *
     * @return Category
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

}
