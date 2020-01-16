<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable() */
class EventStatus
{
    /** @ORM\Column(type = "integer") */
    private $code;

    /** @ORM\Column(type = "string") */
    private $type;

    /** @ORM\Column(type = "string") */
    private $description;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return EventStatus
     */
    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return EventStatus
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return EventStatus
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }
}
