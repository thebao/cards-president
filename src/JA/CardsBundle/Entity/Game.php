<?php

namespace JA\CardsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="player1", type="string", length=255)
     */
    private $player1;

    /**
     * @var string
     *
     * @ORM\Column(name="player2", type="string", length=255)
     */
    private $player2;

    /**
     * @var string
     *
     * @ORM\Column(name="player3", type="string", length=255)
     */
    private $player3;

    /**
     * @var string
     *
     * @ORM\Column(name="player4", type="string", length=255)
     */
    private $player4;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started", type="datetime")
     */
    private $started;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ended", type="datetime")
     */
    private $ended;

    public function __construct()
    {

        $this->started = new \Datetime();
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
     * Set player1
     *
     * @param string $player1
     * @return Game
     */
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    /**
     * Get player1
     *
     * @return string 
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * Set player2
     *
     * @param string $player2
     * @return Game
     */
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;

        return $this;
    }

    /**
     * Get player2
     *
     * @return string 
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Set player3
     *
     * @param string $player3
     * @return Game
     */
    public function setPlayer3($player3)
    {
        $this->player3 = $player3;

        return $this;
    }

    /**
     * Get player3
     *
     * @return string 
     */
    public function getPlayer3()
    {
        return $this->player3;
    }

    /**
     * Set player4
     *
     * @param string $player4
     * @return Game
     */
    public function setPlayer4($player4)
    {
        $this->player4 = $player4;

        return $this;
    }

    /**
     * Get player4
     *
     * @return string 
     */
    public function getPlayer4()
    {
        return $this->player4;
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
}
