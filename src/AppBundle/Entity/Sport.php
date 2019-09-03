<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Sport
 *
 * @ORM\Entity()
 */
class Sport
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
     * Sport name
     *
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    protected $name;

    /**
     * Sport name slug
     *
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    protected $slug;

    /**
     * If the sport is disabled, it will be skipped in the parsers.
     *
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $disabled = true;

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