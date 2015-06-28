<?php

namespace JA\CardsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Card
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $conj="of";
    private $numbers = array(
        "",
        "one",
        "two",
        "three",
        "four",
        "five",
        "six",
        "seven",
        "eight",
        "nine",
        "ten",
        "jack",
        "queen",
        "king"
    );
    private $suits = array(
        "hearts",
        "spades",
        "clubs",
        "diamonds"
    );

    private $faces = array("J","Q","K");
    private $suitsAscii = array(
        "&hearts;",
        "&spades;",
        "&clubs;",
        "&diams;"
    );
    private $joker = "JOKER";
    private $spots = array("spotA1","spotA2","spotA3","spotA4","spotA5","spotB1","spotB2","spotB3","spotB4","spotB5","spotC1","spotC2","spotC3","spotC4","spotC5","ace");

    private $suitPositions = array(
        "0000000000000001",
        "0000010001000000",
        "0000010101000000",
        "1000100000100010",
        "1000100100100010",
        "1010100000101010",
        "1010101000101010",
        "1010101010101010",
        "1101100100110110",
        "1101101010110110"
    );
    /**
     * @var string
     *
     * @ORM\Column(name="suit", type="string", length=255)
     */
    private $suit;

    /**
     * @var string
     *
     * @ORM\Column(name="face", type="string", length=255)
     */
    private $face;

    /**
     * @var string
     *
     * @ORM\Column(name="markup", type="string", length=255)
     */
    private $markup;

    /**
     * @var string
     *
     * @ORM\Column(name="longName", type="string", length=255)
     */
    private $longName;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=255)
     */
    private $uniqueId;

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
     * Set suit
     *
     * @param string $suit
     * @return Card
     */
    public function setSuit($suit)
    {
        $this->suit = $suit;

        return $this;
    }

    /**
     * Get suit
     *
     * @return string 
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Set face
     *
     * @param string $face
     * @return Card
     */
    public function setFace($face)
    {
        $this->face = $face;

        return $this;
    }

    /**
     * Get face
     *
     * @return string 
     */
    public function getFace()
    {
        return $this->face;
    }

    /**
     * Set markup
     *
     * @param string $markup
     * @return Card
     */
    public function setMarkup($markup)
    {
        $this->markup = $markup;

        return $this;
    }

    /**
     * Get markup
     *
     * @return string 
     */
    public function getMarkup()
    {
        return $this->markup;
    }


    public function getJSONArray()
    {
        $array = array();
        $array["face"] = $this->face;
        $array["suit"] = $this->suit;
        $array["uid"] = $this->uniqueId;
        $array["markup"] = $this->generateCardMarkup($this->getSuit(),$this->getFace());
        if($this->face != "jk1" && $this->face != "jk2")
            $array["long_name"] = $this->numbers[$this->face]." ".$this->conj." ".$this->suits[$this->suit];
        else
            $array["long_name"] = "joker";

        return $array;
    }

    public function generateCardMarkup($suit, $face){
        $vizCard="";
        $card=$suit.$face;

        $color="black-card";
		if ($suit !== "jk1" && $suit !== "jk2"){
            $suitName = $this->suitsAscii[$suit];
			$num = $face;
			if ($suitName=="&hearts;" || $suitName =="&diams;")
                $color="red-card";

			//console.log(num);
			if ($num<11){
                $val=$num;
                if ($num==1)
                    $val=14;
                $vizCard = "<div class='card ".$color."' data-val='".$val."' data-name='".$num.$suit."' data-state='off' data-potential='yes' uid='".$this->uniqueId."'>".
                    "<div class='card-back'></div>".
                    "<div class='main'>";
                for($j=0;$j<count($this->spots);$j++){
                    if (substr($this->suitPositions[$num-1],$j,1)!="0"){
                        $inst = $suitName;
                        $vizCard.="<div class='".$this->spots[$j]."'>".$inst."</div>";
					}
				}
                $vizCard.="</div>".
                    "<div class='top-left'>".
                    "<div class=''>".$num."</div>".
                    "<div class='sm-suit'>".$suitName."</div>".
                    "</div>".
                    "<div class='bottom-right'>".
                    "<div class=''>".$num."</div>".
                    "<div class='sm-suit'>".$suitName."</div>".
                    "</div>".
                    "</div>";

            }
			if ($num>10){
                $vizCard = "<div class='card ".$color."'  data-val='".$num."' data-name='".$this->faces[$num-11].$suit."'  data-state='off' data-potential='yes' uid='".$this->uniqueId."'>".
                "<div class='card-back'></div>".
                "<div class='main face'>";
				$vizCard .="<img src='../../../../img/faces/".$card.".png'>";
				$vizCard.="</div>".
                    "<div class='top-left'>".
                    "<div class='condense'>".$this->faces[$num-11]."</div>".
                "<div class='sm-suit'>".$suitName."</div>".
                "</div>".
                "<div class='bottom-right'>".
                "<div class='condense'>".$this->faces[$num-11]."</div>".
                "<div class='sm-suit'>".$suitName."</div>".
                "</div>".
                "</div>";

			}

		}
        else{
            $vizCard = "<div class='card ".$color."' data-val='15' data-name='jk' data-state='off' data-potential='yes' uid='".$this->uniqueId."'>".
                "<div class='card-back'></div>".
                "<div class='main face'>";
            $vizCard .="<img src='../../../../img/faces/jk.png'>";
            $vizCard .="</div>".
                "<div class='top-left'>".
                "<div class='joker condense'>".$this->joker."</div>".
                "</div>".
                "<div class='bottom-right'>".
                "<div class='joker condense '>".$this->joker."</div>".
                "</div>".
                "</div>";
        }


        return $vizCard;

    }

    /**
     * Set longName
     *
     * @param string $longName
     * @return Card
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * Get longName
     *
     * @return string 
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Set uniqueId
     *
     * @param string $uniqueId
     * @return Card
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
}
