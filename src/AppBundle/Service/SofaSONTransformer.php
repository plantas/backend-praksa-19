<?php

namespace AppBundle\Service;

use AppBundle\Entity\SofaSON\SofaSON;
use AppBundle\Entity\SofaSON\SofaSONObject;

class SofaSONTransformer
{

    public const DATA_SOURCE_ID = 'dataSourceId';
    public const FEED_TYPE = 'feedType';
    public const ENTITIES = 'entities';

    public static function fromJson(string $json): SofaSON
    {
        $data = json_decode($json, true);

        $sofaSON = new SofaSON($data[self::DATA_SOURCE_ID], $data[self::FEED_TYPE]);
        $sofaSON->setEntities(self::processArrayValues($data[self::ENTITIES]));

        return $sofaSON;
    }

    protected static function processArrayValues($data)
    {
        $ret = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('entity', $value) && array_key_exists('selector', $value) && array_key_exists('propertyMap', $value)) {
                    $ret[$key] = SofaSONObject::fromEntitySelectorAndPropertyMap($value['entity'], self::processArrayValues($value['selector']), self::processArrayValues($value['propertyMap']));
                } elseif (array_key_exists('entity', $value) && array_key_exists('selector', $value)) {
                    $ret[$key] = SofaSONObject::fromEntityAndSelector($value['entity'], self::processArrayValues($value['selector']));
                } else {
                    $ret[$key] = $value;
                }
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }

}