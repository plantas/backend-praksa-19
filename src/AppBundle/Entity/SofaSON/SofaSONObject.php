<?php


namespace AppBundle\Entity\SofaSON;


class SofaSONObject implements \JsonSerializable
{
    // default entity declaration
    // meant for non object values like integers, strings, arrays, ...
    const PRIMITIVE_DATA_TYPE = '#Primitive';

    // declares that the entity should be updated
    const ACTION_UPDATE = 'update';
    // declares that the entity should be updated or created if it does not exist
    const ACTION_UPSERT = 'upsert';
    // declares that the entity should be deleted
    const ACTION_DELETE = 'delete';

    /**
     * Private constructor, use static creator methods for getting sofason objects.
     *
     * @param string $entity
     * @param string $action
     */
    private function __construct(string $entity, string $action)
    {
        $this->setEntity($entity);
        $this->setAction($action);
    }

    /**
     * @var string
     */
    private $entity = self::PRIMITIVE_DATA_TYPE;

    /**
     * @var array
     */
    private $selector;

    /**
     * @var array
     */
    private $propertyMap;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $action = self::ACTION_UPDATE;

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     */
    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getSelector(): ?array
    {
        return $this->selector;
    }

    /**
     * @param array $selector
     */
    public function setSelector(?array $selector): void
    {
        $this->selector = $selector;
    }

    /**
     * @return array
     */
    public function getPropertyMap(): ?array
    {
        return $this->propertyMap;
    }

    /**
     * @param array $propertyMap
     */
    public function setPropertyMap(?array $propertyMap): void
    {
        $this->propertyMap = $propertyMap;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(?string $action): void
    {
        $this->action = $action;
    }

    public function setExternalId(string $externalId): void
    {
        $this->selector = ['externalId' => $externalId];
    }

    public function jsonSerialize(): array
    {
        $json = [
            'entity' => $this->getEntity(),
            'action' => $this->getAction(),
        ];

        if ($this->getSelector()) {
            $json['selector'] = array_map([self::class, 'serializeRecursive'], $this->getSelector());
        }
        if ($this->getEntity() == self::PRIMITIVE_DATA_TYPE) {
            $json['value'] = $this->getValue();
        }

        if ($this->getPropertyMap()) {
            $json['propertyMap'] = array_map([self::class, 'serializeRecursive'], $this->getPropertyMap());
        }

        return $json;
    }

    private static function serializeRecursive($value)
    {
        if (is_array($value)) {
            return array_map([self::class, 'serializeRecursive'], $value);
        } else if (is_object($value)) {
            if (($value instanceof self)) {
                return $value->jsonSerialize();
            } else {
                throw new \Exception('Unknown SofaSONObject property');
            }
        } else {
            return $value;
        }
    }

    public static function fromEntityAndExternalId(string $entity, string $externalId, string $action = self::ACTION_UPDATE): SofaSONObject
    {
        $sofaSONObject = new self($entity, $action);
        $sofaSONObject->setExternalId($externalId);

        return $sofaSONObject;
    }

    public static function fromEntityExternalIdAndPropertyMap(string $entity, string $externalId, ?array $propertyMap, string $action = self::ACTION_UPDATE): SofaSONObject
    {
        $sofaSONObject = self::fromEntityAndExternalId($entity, $externalId, $action);
        $sofaSONObject->setPropertyMap($propertyMap);

        return $sofaSONObject;
    }

    public static function fromEntityAndSelector(string $entity, array $selector, string $action = self::ACTION_UPDATE): SofaSONObject
    {
        $sofaSONObject = new self($entity, $action);
        $sofaSONObject->setSelector($selector);

        return $sofaSONObject;
    }

    public static function fromEntitySelectorAndPropertyMap(string $entity, array $selector, ?array $propertyMap, string $action = self::ACTION_UPDATE): SofaSONObject
    {
        $sofaSONObject = self::fromEntityAndSelector($entity, $selector, $action);
        $sofaSONObject->setPropertyMap($propertyMap);

        return $sofaSONObject;
    }
}