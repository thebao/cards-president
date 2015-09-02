<?php

namespace JA\CardsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GameSettings
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GameSettings
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
     * @var boolean
     *
     * @ORM\Column(name="revolution", type="boolean")
     */
    private $revolution;

    /**
     * @var boolean
     *
     * @ORM\Column(name="jokers", type="boolean")
     */
    private $jokers;

    /**
     * @var integer *
     * @Assert\Range(
     *      min = 1,
     *      max = 2,
     *      minMessage = "Il faut au moins un jeu pour jouer ;)",
     *      maxMessage = "Maximum 2 jeux par partie"
     * )
     * @ORM\Column(name="decks", type="integer")
     */
    private $decks;

    /**
     * @var integer
     * @Assert\Range(
     *      min = 2,
     *      max = 2,
     *      minMessage = "Il faut etre au moins deux pour jouer ;)",
     *      maxMessage = "Maximum 2 joueurs par partie"
     * )
     * @ORM\Column(name="players", type="integer")
     */
    private $players;

    /**
     * @var boolean
     *
     * @ORM\Column(name="chat", type="boolean")
     */
    private $chat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;


    /**
     * @var String
     *
     * @ORM\COlumn(name="password", type="string", length=255, nullable=true)
     */
    private $password;


    public function __construct()
    {

        $this->chat = true;
        $this->decks = 1;
        $this->players = 2;
        $this->revolution = true;
        $this->jokers = true;
        $this->chat = true;
        $this->private = false;
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
     * Set revolution
     *
     * @param boolean $revolution
     * @return GameSettings
     */
    public function setRevolution($revolution)
    {
        $this->revolution = $revolution;

        return $this;
    }

    /**
     * Get revolution
     *
     * @return boolean 
     */
    public function getRevolution()
    {
        return $this->revolution;
    }

    /**
     * Set jokers
     *
     * @param boolean $jokers
     * @return GameSettings
     */
    public function setJokers($jokers)
    {
        $this->jokers = $jokers;

        return $this;
    }

    /**
     * Get jokers
     *
     * @return boolean 
     */
    public function getJokers()
    {
        return $this->jokers;
    }

    /**
     * Set decks
     *
     * @param integer $decks
     * @return GameSettings
     */
    public function setDecks($decks)
    {
        $this->decks = $decks;

        return $this;
    }

    /**
     * Get decks
     *
     * @return integer 
     */
    public function getDecks()
    {
        return $this->decks;
    }

    /**
     * Set players
     *
     * @param integer $players
     * @return GameSettings
     */
    public function setPlayers($players)
    {
        $this->players = $players;

        return $this;
    }

    /**
     * Get players
     *
     * @return integer 
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set chat
     *
     * @param boolean $chat
     * @return GameSettings
     */
    public function setChat($chat)
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * Get chat
     *
     * @return boolean 
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return GameSettings
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return GameSettings
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
