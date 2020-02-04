<?php


namespace AppBundle\Service;


use AppBundle\Entity\SofaSON\SofaSON;
use AppBundle\Entity\SofaSON\SofaSONObject;
use AppBundle\Entity\Sport;
use AppBundle\Entity\Team;
use AppBundle\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use http\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bridge\Doctrine\ManagerRegistry;


/**
 * Class Persister
 *
 * @package AppBundle\Service\SofaSON
 */
class Persister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var Entity */
    protected $entity;

    public function __construct(\Doctrine\Common\Persistence\ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
    }

    /**
     * Handles processing of the SofaSON as an JSON string and the containing SofaSONObject data. Based on the data entities
     * can be created, deleted or updated.
     *
     * @param string $sofaSON The SofaSON as an JSON string. The processor logic will only expect the data to contain
     *                        the SofaSON declared properties.
     * @throws Exception     In case selector parameter is missing
     */
    public function persistFromJSON(string $sofaSON)
    {
        $this->persistFromArray(json_decode($sofaSON, true));


       /*
        $this->entityManager->persist(new Sport());
        $this->entityManager->flush();
        $this->entityManager->remove(new Sport());
        $this->entityManager->getRepository(Sport::class)->findOneBy(['externalType' => 1, 'externalId' => 1]);
        $this->entityManager->getRepository(Tournament::class)->findOneBy(['externalType' => 1, 'externalId' => 86]);
        $this->entityManager->getRepository(Team::class)->findOneBy(['slug' => 'dugo-selo', 'sport' => 1]);

        if (!isset(json_decode($sofaSON, true)['entities'][0]['selector'])) {
            throw new \InvalidArgumentException();
        }
       */
    }

    /**
     * Handles processing of the SofaSON as an array and the containing SofaSONObject data. Based on the data entities
     * can be created, deleted or updated.
     *
     * @param array $sofaSON The SofaSON as an array. The processor logic will only expect the array to contain
     *                       the SofaSON declared properties.
     * @throws Exception     In case selector parameter is missing
     */
    public function persistFromArray(array $sofaSON)
    {
        $dataSourceId = $sofaSON['dataSourceId'];

        foreach ($sofaSON['entities'] as $entity) {
            $this->persistEntity($entity);
        }
        $this->entityManager->flush();
    }

    protected function persistEntity($data)
    {
        if (!isset($data['selector'])) {
            throw new \InvalidArgumentException();
        }

        // lookup
        $entity = $this->entityManager->getRepository($data['entity'])->findOneBy($this->processArrayValues($data['selector']));

        if (SofaSONObject::ACTION_DELETE === $data['action']) {

           $this->deleteEntity($entity);

        } elseif (SofaSONObject::ACTION_UPDATE === $data['action']) {

           if (!$entity && isset($data['propertyMap'])) {
               throw new Exception('Entity cannot be loaded');
           }
           $this->upsertEntity($entity, $this->processArrayValues($data['propertyMap'] ?? []));

        } elseif (SofaSONObject::ACTION_UPSERT === $data['action']) {

           $entity = $entity ?? new $data['entity']; // create if not exists

           $this->upsertEntity($entity, $this->processArrayValues($data['propertyMap']));

        }
    }

    protected function deleteEntity($entity)
    {
        $this->entityManager->remove($entity);
    }

    protected function upsertEntity($entity, array $data)
    {
        if (empty($data)) return; // nothing to update

        foreach ($data as $key => $value) {
            $this->callSetter($entity, $key, $value);
        }
        $this->entityManager->persist($entity);
    }

    protected function processArrayValues($data)
    {
        $ret = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {

                // entity must be set if property value is array
                if (!array_key_exists('entity', $value)) {
                    throw new \Exception("Invalid entity");
                }

                if (array_key_exists('selector', $value)) {
                    $ret[$key] = $this->entityManager->getRepository($value['entity'])->findOneBy(
                        $this->processArrayValues($value['selector'])
                    );
                } else {
                    // entity without selector could be primitive, plain php object eg. DateTime or Embedabble
                    if (SofaSONObject::PRIMITIVE_DATA_TYPE === $value['entity']) {
                        // #Primitive
                        $ret[$key] = $value['value'];
                    } elseif (isset($value['propertyMap'])) {
                        // has propertyMap
                        $ret[$key] = $this->createObject($value['entity'], $value['propertyMap']);
                    } elseif (isset($value['value'])) {
                        // has value
                        $ret[$key] = $value['value'];
                    } else {
                        throw new \Exception('Invalid entity');
                    }
                }
            } else {
                // shorthand scalar type
                $ret[$key] = $value;
            }
        }

        return $ret;
    }

    private function callSetter($object, string $key, $value)
    {
        $setter = 'set' . ucfirst($key);
        if (method_exists($object, $setter)) {
            $object->$setter($value);
        } else {
            throw new \Exception("Trying to use method " . $setter . "() that does not exists in class " . get_class($object));
        }
    }

    private function createObject(string $class, array $properties)
    {
        $obj = new $class;
        foreach ($properties as $property => $value) {
            $this->callSetter($obj, $property, $value);
        }

        return $obj;
    }


}