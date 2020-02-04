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

                // does not exist yet, create it
                $diffEntities[] = $entity;

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

    /**
     * @param array $a
     * @param array $b
     * @return array list of properties that have changed or didn't exist in stored version
     */
    private function getPropertyMapDifferences(array $a, array $b): array {
        $diff = [];

        foreach ($a as $key => $value) {
            if (isset($b[$key])) {
                // ignore entity's propertyMap list (this is going to be handled separately)
                // existing property
                if (!$this->isEqual($value, $b[$key])) {
                    $diff[$key] = $value;
                }
            } else {
                // new property
                $diff[$key] = $value;
            }
        }
        return $diff;
    }

    private function isEqual($value1, $value2): bool
    {
        if (is_array($value1) && is_array($value2)) {

            if (isset($value1['entity']) && isset($value2['entity']) && isset($value1['selector']) && isset($value2['selector'])) {
                unset($value1['propertyMap'], $value2['propertyMap']);
            }

        }
        return $value1 === $value2;
    }
}
