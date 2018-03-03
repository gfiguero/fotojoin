<?php

namespace FotoJoin\AdminBundle\Entity;

/**
 * Commune
 */
class Commune
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
     * @var \FotoJoin\AdminBundle\Entity\Province
     */
    private $province;

    public function getRegionProvinceName()
    {
        return $this->getName() . ', Región de ' . $this->getProvince()->getRegion()->getName();
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
     * @return Commune
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
     * Set province
     *
     * @param \FotoJoin\AdminBundle\Entity\Province $province
     *
     * @return Commune
     */
    public function setProvince(\FotoJoin\AdminBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \FotoJoin\AdminBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \FotoJoin\UserBundle\Entity\User $user
     *
     * @return Commune
     */
    public function addUser(\FotoJoin\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \FotoJoin\UserBundle\Entity\User $user
     */
    public function removeUser(\FotoJoin\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
