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
     *
     * @ORM\Column(name="gameHandle", type="string", length=255, nullable=true, unique=true)
     */
    protected $gameHandle;

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
     * Set gameHandle
     *
     * @param string $gameHandle
     * @return User
     */
    public function setGameHandle($gameHandle)
    {
        $this->gameHandle = $gameHandle;

        return $this;
    }

    /**
     * Get gameHandle
     *
     * @return string 
     */
    public function getGameHandle()
    {
        return $this->gameHandle;
    }
}
