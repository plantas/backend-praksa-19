<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Category
 *
 * @ORM\Entity()
 */
class Category
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
     * Category name
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $name;

    /**
     * Category name slug
     *
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class)
     * @ORM\JoinColumn(nullable=false)
     * @var Sport
     */
    protected $sport;

    /**
     * Category priority
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $priority;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     * @var boolean
     */
    protected $visible = true;

    /**
     * List of MCCs that would match this category
     *
     * @ORM\Column(type="simple_array", nullable=true)
     * @var array
     */
    protected $mcc;

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
     * @return array
     */
    public function getMcc(): array
    {
        return $this->mcc;
    }

    /**
     * @param array $mcc
     */
    public function setMcc(array $mcc): void
    {
        $this->mcc = $mcc;
    }
}