<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Manager
 *
 * @ORM\Entity()
 */
class Manager
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
     * Manager name
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Name slug
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     * @var string
     */
    protected $shortName;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="manager")
     * @var Team[]
     */
    protected $teams;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(type="string", nullable=true, length=30)
     * @var string
     */
    protected $nationality;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array
     */
    protected $extra;

    /**
     * @ORM\ManyToOne(targetEntity=Manager::class, inversedBy="duplicates")
     * @var Manager
     */
    protected $duplicateOf;

    /**
     * @ORM\OneToMany(targetEntity=Manager::class, mappedBy="duplicateOf")
     * @var array
     */
    protected $duplicates;

//    /**
//     * @ORM\OneToOne(targetEntity="SofaScore\ModelBundle\Entity\External\Player\Player")
//     * @var Player
//     */
//    protected $formerPlayer;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
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
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams(array $teams): void
    {
        $this->teams = $teams;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth(\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
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
     * @return Manager
     */
    public function getDuplicateOf(): Manager
    {
        return $this->duplicateOf;
    }

    /**
     * @param Manager $duplicateOf
     */
    public function setDuplicateOf(Manager $duplicateOf): void
    {
        $this->duplicateOf = $duplicateOf;
    }

    /**
     * @return array
     */
    public function getDuplicates(): array
    {
        return $this->duplicates;
    }

    /**
     * @param array $duplicates
     */
    public function setDuplicates(array $duplicates): void
    {
        $this->duplicates = $duplicates;
    }
}