<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(name="twitter", type="integer", nullable=true)
     */
    protected $twitter;

    /**
     * @var string
     * @ORM\Column(name="client_id", type="string", nullable=true)
     */
    protected $client_id;

    /**
     * @var string
     * @ORM\Column(name="client_secret", type="string", nullable=true)
     */
    protected $client_secret;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set twitter
     *
     * @param integer $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return integer
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set clientId
     *
     * @param string $clientId
     *
     * @return User
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set clientSecret
     *
     * @param string $clientSecret
     *
     * @return User
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * Get clientSecret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }
}
