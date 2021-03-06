<?php

namespace JA\CardsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JA\UserBundle\JAUserBundle;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Game
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Game
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=255)
     */
    private $uniqueId;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="JA\UserBundle\Entity\User")
     */
    private $owner;

    /**
     * @var User
     * @ORM\ManyToMany(targetEntity="JA\UserBundle\Entity\User", inversedBy="cables")
     */
    private $players;

    /**
     * @var GameSettings
     * @ORM\OneToOne(targetEntity="JA\CardsBundle\Entity\GameSettings")
     */
    private $settings;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started", type="datetime")
     */
    private $started;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended", type="datetime", nullable=true)
     */
    private $ended;


    public function __construct()
    {

        $this->started = new \Datetime();
        $this->uniqueId = hash('md5',uniqid('', true));
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
     * Set uniqueId
     *
     * @param string $uniqueId
     * @return Game
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * Get uniqueId
     *
     * @return string 
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     * @return Game
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime 
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set ended
     *
     * @param \DateTime $ended
     * @return Game
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return \DateTime 
     */
    public function getEnded()
    {
        return $this->ended;
    }


    /**
     * Set owner
     *
     * @param \JA\UserBundle\Entity\User $owner
     * @return Game
     */
    public function setOwner(\JA\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \JA\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add players
     *
     * @param \JA\UserBundle\Entity\User $players
     * @return Game
     */
    public function addPlayer(\JA\UserBundle\Entity\User $players)
    {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     *
     * @param \JA\UserBundle\Entity\User $players
     */
    public function removePlayer(\JA\UserBundle\Entity\User $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    public function getJsonPlayers()
    {
        $array = array();
        foreach($this->players as $i=>$player)
        {
            $array[$i]['name'] = $player->getUsername();
            $array[$i]['id'] =  $player->getId();

        }
        return $array;
    }
    /**
     * Set settings
     *
     * @param \JA\CardsBundle\Entity\GameSettings $settings
     * @return Game
     */
    public function setSettings(\JA\CardsBundle\Entity\GameSettings $settings = null)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * Get settings
     *
     * @return \JA\CardsBundle\Entity\GameSettings 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    public function getJsonArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['uniqueId'] = $this->uniqueId;
        $array['owner'] = $this->owner->getUsername();
        $array['started'] = $this->started;
        $array['revolution'] = $this->settings->getRevolution();
        $array['chat'] = $this->settings->getChat();
        $array['decks'] = $this->settings->getDecks();
        $array['maxPlayers'] = $this->settings->getPlayers();
        $array['private'] = $this->settings->getPrivate();
        $array['password'] = $this->settings->getPassword();
        $array['players'] = $this->getJsonPlayers();

        return $array;
    }
}
