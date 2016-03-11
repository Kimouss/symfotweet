<?php

namespace WallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tweets
 *
 * @ORM\Table(name="tweets")
 * @ORM\Entity(repositoryClass="WallBundle\Repository\TweetsRepository")
 */
class Tweets
{
    /**
     * @ORM\ManyToOne(targetEntity="wall")
     * @ORM\JoinColumn(name="wall", onDelete="CASCADE")
     */
    private $wall;

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
     * @ORM\Column(name="userTweet", type="string", length=255)
     */
    private $userTweet;

    /**
     * @var string
     *
     * @ORM\Column(name="tweet", type="string", length=255)
     */
    private $tweet;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish", type="boolean", nullable=true)
     */
    private $publish;


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
     * Set userTweet
     *
     * @param string $userTweet
     *
     * @return Tweets
     */
    public function setUserTweet($userTweet)
    {
        $this->userTweet = $userTweet;

        return $this;
    }

    /**
     * Get userTweet
     *
     * @return string
     */
    public function getUserTweet()
    {
        return $this->userTweet;
    }

    /**
     * Set tweet
     *
     * @param string $tweet
     *
     * @return Tweets
     */
    public function setTweet($tweet)
    {
        $this->tweet = $tweet;

        return $this;
    }

    /**
     * Get tweet
     *
     * @return string
     */
    public function getTweet()
    {
        return $this->tweet;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Tweets
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set wall
     *
     * @param \WallBundle\Entity\wall $wall
     *
     * @return Tweets
     */
    public function setWall(\WallBundle\Entity\wall $wall = null)
    {
        $this->wall = $wall;

        return $this;
    }

    /**
     * Get wall
     *
     * @return \WallBundle\Entity\wall
     */
    public function getWall()
    {
        return $this->wall;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     *
     * @return Tweets
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return boolean
     */
    public function getPublish()
    {
        return $this->publish;
    }
}
