<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Tournament
 *
 * @ORM\Entity()
 */
class Tournament
{

    const DEFAULT_PRIORITY = 0;

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
     * Tournament name
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Tournament name slug
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity=UniqueTournament::class)
     * @var UniqueTournament
     */
    protected $uniqueTournament;

//    /**
//     * @ORM\ManyToOne(targetEntity="SofaScore\ModelBundle\Entity\External\Tennis\TennisSeason")
//     * @var TennisSeason
//     */
//    protected $tennisSeason;

//    /**
//     * @ORM\ManyToOne(targetEntity="SofaScore\ModelBundle\Entity\External\Tennis\TennisEvent")
//     * @var TennisEvent
//     */
//    protected $tennisEvent;

    /**
     * Tournament priority
     *
     * @ORM\Column(type="integer", options={"default":0})
     * @var int
     */
    protected $priority = 0;

    /**
     * Tournament order
     *
     * @ORM\Column(name="`order`", type="integer", options={"default":0})
     * @var int
     */
    protected $order = 0;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     * @var boolean
     */
    protected $visible = true;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     * @var int
     */
    protected $userCount = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * boolean
     */
    protected $isMobileStream;

    /**
     * This field contains extra information for each tournament type. Only information that is not important, or
     * cannot be saved as an entity is allowed to be saved here!
     *
     * @ORM\Column(type="json", nullable=true)
     *
     * @var array
     */
    protected $extra;

//    /**
//     * @ORM\OneToMany(targetEntity="SofaScore\ModelBundle\Entity\External\Event\Highlight", mappedBy="tournament",
//     *                                                                                      cascade={"ALL"},
//     *                                                                                      orphanRemoval=true)
//     */
//    protected $highlights;

    /**
     * Tournament primary color
     *
     * @ORM\Column(name="`primary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $primaryColor = 0;

    /**
     * Tournament secondary color
     *
     * @ORM\Column(name="`secondary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $secondaryColor = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * boolean
     */
    protected $isGroup;

    /**
     * Tournament name when looked as group of a unique tournament
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $groupName;

    /**
     * Prefix for round names of all the events in the tournament. E.g. "UCL Preliminary Round" Tournament has round prefix "Preliminary"
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $roundPrefix;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     * @var boolean
     */
    protected $disabled = false;

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
     * @return UniqueTournament
     */
    public function getUniqueTournament(): UniqueTournament
    {
        return $this->uniqueTournament;
    }

    /**
     * @param UniqueTournament $uniqueTournament
     */
    public function setUniqueTournament(UniqueTournament $uniqueTournament): void
    {
        $this->uniqueTournament = $uniqueTournament;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
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
     * @return mixed
     */
    public function getIsMobileStream()
    {
        return $this->isMobileStream;
    }

    /**
     * @param mixed $isMobileStream
     */
    public function setIsMobileStream($isMobileStream): void
    {
        $this->isMobileStream = $isMobileStream;
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
     * @return mixed
     */
    public function getIsGroup()
    {
        return $this->isGroup;
    }

    /**
     * @param mixed $isGroup
     */
    public function setIsGroup($isGroup): void
    {
        $this->isGroup = $isGroup;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getRoundPrefix(): string
    {
        return $this->roundPrefix;
    }

    /**
     * @param string $roundPrefix
     */
    public function setRoundPrefix(string $roundPrefix): void
    {
        $this->roundPrefix = $roundPrefix;
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
}