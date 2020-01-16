<?php


namespace AppBundle\Service;


use AppBundle\Entity\SofaSON\SofaSONObject;

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
        $diffEntities = [];

        foreach ($sofaSON['entities'] as $entity) {
            $existingPropertyMap = $this->storage->get($sofaSON['dataSourceId'], $entity['entity'], $entity['selector'], $sofaSON['feedType']);

            if (!$existingPropertyMap) {

                // does not exist, create if action not delete
                if (SofaSONObject::ACTION_DELETE != $entity['action']) {
                    $entity['action'] = SofaSONObject::ACTION_UPSERT;

                    $diffEntities[] = $entity;
                }

            } else {
                if ($entity['propertyMap']) {
                    // update if differs
                    if ($diff = $this->getPropertyMapDifferences($entity['propertyMap'], $existingPropertyMap)) {
                        $entity['propertyMap'] = $diff;
                        $entity['action'] = SofaSONObject::ACTION_UPDATE;

                        $diffEntities[] = $entity;
                    }
                } else {
                    // does not have properties, could be delete action
                    if (SofaSONObject::ACTION_DELETE == $entity['action']) {

                        $diffEntities[] = $entity;
                    }
                }
            }
        }
        $sofaSON['entities'] = $diffEntities;

        return $sofaSON;
    }

    private function getPropertyMapDifferences(array $a, array $b): array {
        //return (is_array($a) && is_array($b) && count($a) === count($b) && strcmp(json_encode($a), json_encode($b)) === 0);
        $diff = [];

        foreach ($a as $key => $value) {
            if (isset($b[$key])) {
                // exiting property
                if ($value !== $b[$key]) {
                    $diff[$key] = $value;
                }
            } else {
                // new property
                $diff[$key] = $value;
            }
        }
        return $diff;
    }
}
