<?php


namespace AppBundle\Entity\SofaSON;


class SofaSON implements \JsonSerializable
{
    /**
     * @var int
     */
    private $dataSourceId;

    /**
     * @var string
     */
    private $feedType;

    /**
     * @var SofaSONObject[]
     */
    private $entities;

    /**
     * SofaSON constructor.
     *
     * @param int             $dataSourceId
     * @param string          $feedType
     * @param SofaSONObject[] $entities
     */
    public function __construct(int $dataSourceId, string $feedType, array $entities = [])
    {
        $this->dataSourceId = $dataSourceId;
        $this->feedType     = $feedType;
        $this->entities     = $entities;
    }


    /**
     * @return int
     */
    public function getDataSourceId(): int
    {
        return $this->dataSourceId;
    }

    /**
     * @param int $dataSourceId
     */
    public function setDataSourceId(int $dataSourceId): void
    {
        $this->dataSourceId = $dataSourceId;
    }

    /**
     * @return string
     */
    public function getFeedType(): ?string
    {
        return $this->feedType;
    }

    /**
     * @param string $feedType
     */
    public function setFeedType(?string $feedType): void
    {
        $this->feedType = $feedType;
    }

    /**
     * @return SofaSONObject[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param SofaSONObject[] $entities
     */
    public function setEntities(array $entities): void
    {
        $this->entities = $entities;
    }

    public function addEntity(SofaSONObject $sofaSONObject): void
    {
        $this->entities[] = $sofaSONObject;
    }


    public function jsonSerialize(): array
    {
        return [
            'dataSourceId' => $this->getDataSourceId(),
            'feedType'     => $this->getFeedType(),
            'entities'     => array_map(function (SofaSONObject $object) {
                return $object->jsonSerialize();
            }, $this->getEntities())
        ];
    }
}