<?php

namespace FotoJoin\ControlPanelBundle\Entity;

/**
 * Album
 */
class Album
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
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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
     * @return Album
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
     * @return Album
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
     * @return Album
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
     * @var \FotoJoin\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \FotoJoin\UserBundle\Entity\User $user
     *
     * @return Album
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
    private $photographies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photographies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photography
     *
     * @param \FotoJoin\ControlPanelBundle\Entity\Photography $photography
     *
     * @return Album
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

    public function countPhotographies()
    {
        return $this->photographies->count();
    }
}
