<?php

namespace WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * wall
 *
 * @ORM\Table(name="wall")
 * @ORM\Entity(repositoryClass="WallBundle\Repository\wallRepository")
 */
class wall
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="typeSearch", type="string", length=255)
     */
    private $typeSearch;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=255)
     */
    private $search;

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin", type="boolean", length=255)
     */
    private $admin;

    /**
     * @var string
     *
     * @ORM\Column(name="time", type="string", length=255)
     */
    private $time;


    /**
     * Get id
     *
     * @return int
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
     * @return wall
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
     * Set admin
     *
     * @param string $admin
     *
     * @return wall
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return string
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set time
     *
     * @param string $time
     *
     * @return wall
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return wall
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set search
     *
     * @param string $search
     *
     * @return wall
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set typeSearch
     *
     * @param string $typeSearch
     *
     * @return wall
     */
    public function setTypeSearch($typeSearch)
    {
        $this->typeSearch = $typeSearch;

        return $this;
    }

    /**
     * Get typeSearch
     *
     * @return string
     */
    public function getTypeSearch()
    {
        return $this->typeSearch;
    }
}
