<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Team
 *
 * @ORM\Entity()
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * Id of the object in the external database
     *
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(value=0)
     * @var int
     */
    protected $externalId;

    /**
     * Id of the external database (betradar, scorespro)
     *
     * @ORM\Column(type="smallint")
     * @var int
     */
    protected $externalType;

    /**
     * Team name
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Team name slug
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    protected $shortName;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     * @var string
     */
    protected $gender;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Sport
     */
    protected $sport;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity=Tournament::class)
     * @ORM\JoinColumn(nullable=true)
     * @var Tournament
     */
    protected $tournament;

    /**
     * @ORM\Embedded(class="TeamColor")
     */
    protected $homeColor;

    /**
     * @ORM\Embedded(class="TeamColor")
     */
    protected $awayColor;

    /**
     * @ORM\Embedded(class="TeamColor")
     */
    protected $homeGoalkeeperColor;

    /**
     * @ORM\Embedded(class="TeamColor")
     */
    protected $awayGoalkeeperColor;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @var Team
     */
    protected $subTeam1;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @var Team
     */
    protected $subTeam2;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     * @var int
     */
    protected $userCount = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Manager::class, inversedBy="teams")
     * @var Manager
     */
    protected $manager;

//    /**
//     * @ORM\OneToMany(targetEntity="SofaScore\ModelBundle\Entity\External\Team\TeamPlayer", cascade={"ALL"},
//     *                                                                                      mappedBy="team")
//     * @var TeamPlayer[]
//     */
//    protected $players;

//    /**
//     * @ORM\OneToMany(targetEntity="SofaScore\ModelBundle\Entity\External\Tennis\TennisRanking", mappedBy="team")
//     *
//     * @var TennisRanking[]
//     */
//    protected $tennisRanking;

//    /**
//     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rankings\TeamRanking", mappedBy="team")
//     *
//     * @var TeamRanking[]
//     */
//    protected $teamRankings;

//???
//    /**
//     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Team\PlayerTeamInfo", mappedBy="team")
//     * @var PlayerTeamInfo
//     */
//    protected $playerTeamInfo;

//    /**
//     * @ORM\ManyToOne(targetEntity="SofaScore\ModelBundle\Entity\External\Venue\Venue")
//     * @Serializer\Groups({"venue"})
//     * @var Venue
//     */
//    protected $venue;

    /**
     * @ORM\Column(type="json", nullable=true)
     *
     * @var array
     */
    protected $extra;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $foundationDate;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     * @var string
     */
    protected $nameCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @return array
     */
    protected $ranking;

    /**
     * A value that determines the importance of the team from a sport aspect
     *
     * Values:
     * 4 - top class
     * 3 - high class
     * 1 - low class
     * 0 - no class
     *
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $class;

    /**
     * Team primary color
     *
     * @ORM\Column(name="`primary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $primaryColor;

    /**
     * Team secondary color
     *
     * @ORM\Column(name="`secondary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $secondaryColor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $disabled;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $national;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="duplicates")
     * @var Team
     */
    protected $duplicateOf;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="duplicateOf")
     * @var Team[]
     */
    protected $duplicates;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="childTeams")
     * @var Team
     */
    protected $parentTeam;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="parentTeam")
     * @var Team[]
     */
    protected $childTeams;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $nationalTeamPlayersCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $foreignPlayersCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int|null
     */
    protected $outrightType;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime|null
     */
    protected $managerContractUntil;

    public function __construct()
    {
//        $this->players        = new ArrayCollection();
//        $this->tennisRanking  = new ArrayCollection();
//        $this->playerTeamInfo = new ArrayCollection();
//        $this->country        = new Country();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getExternalId(): int
    {
        return $this->externalId;
    }

    /**
     * @param int $externalId
     */
    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return int
     */
    public function getExternalType(): int
    {
        return $this->externalType;
    }

    /**
     * @param int $externalType
     */
    public function setExternalType(int $externalType): void
    {
        $this->externalType = $externalType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void
    {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport(Sport $sport): void
    {
        $this->sport = $sport;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Tournament
     */
    public function getTournament(): Tournament
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament(Tournament $tournament): void
    {
        $this->tournament = $tournament;
    }

    /**
     * @return mixed
     */
    public function getHomeColor()
    {
        return $this->homeColor;
    }

    /**
     * @param mixed $homeColor
     */
    public function setHomeColor($homeColor): void
    {
        $this->homeColor = $homeColor;
    }

    /**
     * @return mixed
     */
    public function getAwayColor()
    {
        return $this->awayColor;
    }

    /**
     * @param mixed $awayColor
     */
    public function setAwayColor($awayColor): void
    {
        $this->awayColor = $awayColor;
    }

    /**
     * @return mixed
     */
    public function getHomeGoalkeeperColor()
    {
        return $this->homeGoalkeeperColor;
    }

    /**
     * @param mixed $homeGoalkeeperColor
     */
    public function setHomeGoalkeeperColor($homeGoalkeeperColor): void
    {
        $this->homeGoalkeeperColor = $homeGoalkeeperColor;
    }

    /**
     * @return mixed
     */
    public function getAwayGoalkeeperColor()
    {
        return $this->awayGoalkeeperColor;
    }

    /**
     * @param mixed $awayGoalkeeperColor
     */
    public function setAwayGoalkeeperColor($awayGoalkeeperColor): void
    {
        $this->awayGoalkeeperColor = $awayGoalkeeperColor;
    }

    /**
     * @return Team
     */
    public function getSubTeam1(): Team
    {
        return $this->subTeam1;
    }

    /**
     * @param Team $subTeam1
     */
    public function setSubTeam1(Team $subTeam1): void
    {
        $this->subTeam1 = $subTeam1;
    }

    /**
     * @return Team
     */
    public function getSubTeam2(): Team
    {
        return $this->subTeam2;
    }

    /**
     * @param Team $subTeam2
     */
    public function setSubTeam2(Team $subTeam2): void
    {
        $this->subTeam2 = $subTeam2;
    }

    /**
     * @return int
     */
    public function getUserCount(): int
    {
        return $this->userCount;
    }

    /**
     * @param int $userCount
     */
    public function setUserCount(int $userCount): void
    {
        $this->userCount = $userCount;
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     */
    public function setManager(Manager $manager): void
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     */
    public function setExtra(array $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * @return \DateTime
     */
    public function getFoundationDate(): \DateTime
    {
        return $this->foundationDate;
    }

    /**
     * @param \DateTime $foundationDate
     */
    public function setFoundationDate(\DateTime $foundationDate): void
    {
        $this->foundationDate = $foundationDate;
    }

    /**
     * @return string
     */
    public function getNameCode(): string
    {
        return $this->nameCode;
    }

    /**
     * @param string $nameCode
     */
    public function setNameCode(string $nameCode): void
    {
        $this->nameCode = $nameCode;
    }

    /**
     * @return mixed
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * @param mixed $ranking
     */
    public function setRanking($ranking): void
    {
        $this->ranking = $ranking;
    }

    /**
     * @return int
     */
    public function getClass(): int
    {
        return $this->class;
    }

    /**
     * @param int $class
     */
    public function setClass(int $class): void
    {
        $this->class = $class;
    }

    /**
     * @return int
     */
    public function getPrimaryColor(): int
    {
        return $this->primaryColor;
    }

    /**
     * @param int $primaryColor
     */
    public function setPrimaryColor(int $primaryColor): void
    {
        $this->primaryColor = $primaryColor;
    }

    /**
     * @return int
     */
    public function getSecondaryColor(): int
    {
        return $this->secondaryColor;
    }

    /**
     * @param int $secondaryColor
     */
    public function setSecondaryColor(int $secondaryColor): void
    {
        $this->secondaryColor = $secondaryColor;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     */
    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    /**
     * @return bool
     */
    public function isNational(): bool
    {
        return $this->national;
    }

    /**
     * @param bool $national
     */
    public function setNational(bool $national): void
    {
        $this->national = $national;
    }

    /**
     * @return Team
     */
    public function getDuplicateOf(): Team
    {
        return $this->duplicateOf;
    }

    /**
     * @param Team $duplicateOf
     */
    public function setDuplicateOf(Team $duplicateOf): void
    {
        $this->duplicateOf = $duplicateOf;
    }

    /**
     * @return Team[]
     */
    public function getDuplicates(): array
    {
        return $this->duplicates;
    }

    /**
     * @param Team[] $duplicates
     */
    public function setDuplicates(array $duplicates): void
    {
        $this->duplicates = $duplicates;
    }

    /**
     * @return Team
     */
    public function getParentTeam(): Team
    {
        return $this->parentTeam;
    }

    /**
     * @param Team $parentTeam
     */
    public function setParentTeam(Team $parentTeam): void
    {
        $this->parentTeam = $parentTeam;
    }

    /**
     * @return Team[]
     */
    public function getChildTeams(): array
    {
        return $this->childTeams;
    }

    /**
     * @param Team[] $childTeams
     */
    public function setChildTeams(array $childTeams): void
    {
        $this->childTeams = $childTeams;
    }

    /**
     * @return int
     */
    public function getNationalTeamPlayersCount(): int
    {
        return $this->nationalTeamPlayersCount;
    }

    /**
     * @param int $nationalTeamPlayersCount
     */
    public function setNationalTeamPlayersCount(int $nationalTeamPlayersCount): void
    {
        $this->nationalTeamPlayersCount = $nationalTeamPlayersCount;
    }

    /**
     * @return int
     */
    public function getForeignPlayersCount(): int
    {
        return $this->foreignPlayersCount;
    }

    /**
     * @param int $foreignPlayersCount
     */
    public function setForeignPlayersCount(int $foreignPlayersCount): void
    {
        $this->foreignPlayersCount = $foreignPlayersCount;
    }

    /**
     * @return int|null
     */
    public function getOutrightType(): ?int
    {
        return $this->outrightType;
    }

    /**
     * @param int|null $outrightType
     */
    public function setOutrightType(?int $outrightType): void
    {
        $this->outrightType = $outrightType;
    }

    /**
     * @return \DateTime|null
     */
    public function getManagerContractUntil(): ?\DateTime
    {
        return $this->managerContractUntil;
    }

    /**
     * @param \DateTime|null $managerContractUntil
     */
    public function setManagerContractUntil(?\DateTime $managerContractUntil): void
    {
        $this->managerContractUntil = $managerContractUntil;
    }
}
