<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goal
 *
 * @ORM\Table(name="goal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GoalRepository")
 */
class Goal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="externalId", type="integer")
     */
    private $externalId;

    /**
     * @var int
     *
     * @ORM\Column(name="externalType", type="integer")
     */
    private $externalType;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="goals")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var string
     *
     * @ORM\Column(name="player", type="string", length=255)
     */
    private $player;

    /**
     * @var string
     *
     * @ORM\Column(name="assist", type="string", length=255, nullable=true)
     */
    private $assist;

    /**
     * @var int
     *
     * @ORM\Column(name="homeScore", type="integer")
     */
    private $homeScore;

    /**
     * @var int
     *
     * @ORM\Column(name="awayScore", type="integer")
     */
    private $awayScore;

    /**
     * @var int
     *
     * @ORM\Column(name="minute", type="integer")
     */
    private $minute;

    /**
     * @var int
     *
     * @ORM\Column(name="addedMinute", type="integer")
     */
    private $addedMinute;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set externalId.
     *
     * @param int $externalId
     *
     * @return Goal
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get externalId.
     *
     * @return int
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set externalType.
     *
     * @param int $externalType
     *
     * @return Goal
     */
    public function setExternalType($externalType)
    {
        $this->externalType = $externalType;

        return $this;
    }

    /**
     * Get externalType.
     *
     * @return int
     */
    public function getExternalType()
    {
        return $this->externalType;
    }

    /**
     * Set event.
     *
     * @param Event $event
     *
     * @return Goal
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set player.
     *
     * @param string $player
     *
     * @return Goal
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return string
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set assist.
     *
     * @param string $assist
     *
     * @return Goal
     */
    public function setAssist($assist)
    {
        $this->assist = $assist;

        return $this;
    }

    /**
     * Get assist.
     *
     * @return string
     */
    public function getAssist()
    {
        return $this->assist;
    }

    /**
     * Set homeScore.
     *
     * @param int $homeScore
     *
     * @return Goal
     */
    public function setHomeScore($homeScore)
    {
        $this->homeScore = $homeScore;

        return $this;
    }

    /**
     * Get homeScore.
     *
     * @return int
     */
    public function getHomeScore()
    {
        return $this->homeScore;
    }

    /**
     * Set awayScore.
     *
     * @param int $awayScore
     *
     * @return Goal
     */
    public function setAwayScore($awayScore)
    {
        $this->awayScore = $awayScore;

        return $this;
    }

    /**
     * Get awayScore.
     *
     * @return int
     */
    public function getAwayScore()
    {
        return $this->awayScore;
    }

    /**
     * Set minute.
     *
     * @param int $minute
     *
     * @return Goal
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;

        return $this;
    }

    /**
     * Get minute.
     *
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * Set addedMinute.
     *
     * @param int $addedMinute
     *
     * @return Goal
     */
    public function setAddedMinute($addedMinute)
    {
        $this->addedMinute = $addedMinute;

        return $this;
    }

    /**
     * Get addedMinute.
     *
     * @return int
     */
    public function getAddedMinute()
    {
        return $this->addedMinute;
    }
}
