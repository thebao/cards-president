<?php

namespace JA\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * @ORM\Column(name="currentGame", type="string", length=255)
     */
    private $currentGame;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set currentGame
     *
     * @param string $currentGame
     * @return User
     */
    public function setCurrentGame($currentGame)
    {
        $this->currentGame = $currentGame;

        return $this;
    }

    /**
     * Get currentGame
     *
     * @return string 
     */
    public function getCurrentGame()
    {
        return $this->currentGame;
    }
}
