<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class TeamColor
 *
 * @ORM\Embeddable()
 */
class TeamColor
{

    const DEFAULT_OUTLINE_COLOR = 8421504;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $hStripes = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $main = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $number = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $sleeve = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $split = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $squares = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $vStripes = -1;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $outline = -1;

    /**
     * @return mixed
     */
    public function getHStripes()
    {
        return $this->hStripes;
    }

    /**
     * @param mixed $hStripes
     */
    public function setHStripes($hStripes): void
    {
        $this->hStripes = $hStripes;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param mixed $main
     */
    public function setMain($main): void
    {
        $this->main = $main;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getSleeve()
    {
        return $this->sleeve;
    }

    /**
     * @param mixed $sleeve
     */
    public function setSleeve($sleeve): void
    {
        $this->sleeve = $sleeve;
    }

    /**
     * @return mixed
     */
    public function getSplit()
    {
        return $this->split;
    }

    /**
     * @param mixed $split
     */
    public function setSplit($split): void
    {
        $this->split = $split;
    }

    /**
     * @return mixed
     */
    public function getSquares()
    {
        return $this->squares;
    }

    /**
     * @param mixed $squares
     */
    public function setSquares($squares): void
    {
        $this->squares = $squares;
    }

    /**
     * @return mixed
     */
    public function getVStripes()
    {
        return $this->vStripes;
    }

    /**
     * @param mixed $vStripes
     */
    public function setVStripes($vStripes): void
    {
        $this->vStripes = $vStripes;
    }

    /**
     * @return mixed
     */
    public function getOutline()
    {
        return $this->outline;
    }

    /**
     * @param mixed $outline
     */
    public function setOutline($outline): void
    {
        $this->outline = $outline;
    }
}