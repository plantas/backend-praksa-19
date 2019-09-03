<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class UniqueTournament
 *
 * @ORM\Entity()
 */
class UniqueTournament
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
     * Unique tournament name
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Unique tournament name slug
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * Unique tournament priority
     *
     * @ORM\Column(type="integer", options={"default":0})
     * @var int
     */
    protected $priority = 0;

    /**
     * Unique tournament order
     *
     * @ORM\Column(name="`order`", type="integer", options={"default":0})
     * @var int
     */
    protected $order = 0;

//    /**
//     * @ORM\OneToMany(targetEntity="SofaScore\ModelBundle\Entity\External\Event\Highlight", mappedBy="uniqueTournament",
//     *                                                                                      cascade={"ALL"},
//     *                                                                                      orphanRemoval=true)
//     */
//    protected $highlights;

    /**
     * Unique tournament primary color
     *
     * @ORM\Column(name="`primary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $primaryColor = -1;

    /**
     * Unique tournament secondary color
     *
     * @ORM\Column(name="`secondary_color`", type="integer", nullable=true)
     * @var int
     */
    protected $secondaryColor = -1;

    /**
     * This field contains extra information for each unique tournament. Only information that is not important, or
     * cannot be saved as an entity is allowed to be saved here!
     *
     * @ORM\Column(type="json", nullable=true)
     *
     * @var array
     */
    protected $extra;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Category
     */
    protected $category;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    protected $hasEventPlayerStatistics;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    protected $hasEventPlayerHeatMap;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     * @var int
     */
    protected $userCount = 0;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     * @var boolean
     */
    protected $visible = true;

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
     * @return bool
     */
    public function isHasEventPlayerStatistics(): bool
    {
        return $this->hasEventPlayerStatistics;
    }

    /**
     * @param bool $hasEventPlayerStatistics
     */
    public function setHasEventPlayerStatistics(bool $hasEventPlayerStatistics): void
    {
        $this->hasEventPlayerStatistics = $hasEventPlayerStatistics;
    }

    /**
     * @return bool
     */
    public function isHasEventPlayerHeatMap(): bool
    {
        return $this->hasEventPlayerHeatMap;
    }

    /**
     * @param bool $hasEventPlayerHeatMap
     */
    public function setHasEventPlayerHeatMap(bool $hasEventPlayerHeatMap): void
    {
        $this->hasEventPlayerHeatMap = $hasEventPlayerHeatMap;
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
}
