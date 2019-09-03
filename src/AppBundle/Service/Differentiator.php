<?php


namespace AppBundle\Service;


class Differentiator
{
    /** @var DataStorageInterface */
    protected $storage;

    public function __construct(DataStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function diff(?array $sofaSON): ?array
    {
        return $sofaSON;
    }
}
