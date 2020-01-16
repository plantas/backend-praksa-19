<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
{
    public function __construct()
    {
        $this->status = new EventStatus();
        $this->goals = new ArrayCollection();
    }

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
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Sport
     */
    private $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Tournament::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Tournament
     */
    private $tournament;

    /**
     * @ORM\Embedded(class=EventStatus::class)
     * @var EventStatus
     */
    private $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Team
     */
    private $homeTeam;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Team
     */
    private $awayTeam;

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
     * @var ArrayCollection|Goal []
     *
     * @ORM\OneToMany(targetEntity=Goal::class, mappedBy="event")
     */
    private $goals;

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
     * @return Event
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
     * @return Event
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
     * Set sport.
     *
     * @param Sport $sport
     *
     * @return Event
     */
    public function setSport(Sport $sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport.
     *
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set tournament.
     *
     * @param Tournament $tournament
     *
     * @return Event
     */
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament.
     *
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set status.
     *
     * @param EventStatus $status
     *
     * @return Event
     */
    public function setStatus(EventStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return EventStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set startDate.
     *
     * @param DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set homeTeam.
     *
     * @param Team $homeTeam
     *
     * @return Event
     */
    public function setHomeTeam(Team $homeTeam)
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    /**
     * Get homeTeam.
     *
     * @return Team
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam.
     *
     * @param Team $awayTeam
     *
     * @return Event
     */
    public function setAwayTeam(Team $awayTeam)
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * Get awayTeam.
     *
     * @return Team
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set homeScore.
     *
     * @param int $homeScore
     *
     * @return Event
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
     * @return Event
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
     * Set goals.
     *
     * @param Goal[] $goals
     *
     * @return Event
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals.
     *
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    /**
     * @param Goal $goal
     * @return Event
     */
    public function addGoal(Goal $goal)
    {
        if (!$this->goals->contains($goal)) {
            $this->goals->add($goal);
        }

        return $this;
    }
}

