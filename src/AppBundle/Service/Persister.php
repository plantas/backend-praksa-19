<?php


namespace AppBundle\Service;


use AppBundle\Entity\Sport;
use AppBundle\Entity\Team;
use AppBundle\Entity\Tournament;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->entityManager = $managerRegistry->getManager();
    }

    /**
     * Handles processing of the SofaSON as an JSON string and the containing SofaSONObject data. Based on the data entities
     * can be created, deleted or updated.
     *
     * @param string $sofaSON The SofaSON as an JSON string. The processor logic will only expect the data to contain
     *                        the SofaSON declared properties.
     */
    public function persistFromJSON(string $sofaSON)
    {
        $this->entityManager->persist(new Sport());
        $this->entityManager->flush();
        $this->entityManager->remove(new Sport());
        $this->entityManager->getRepository(Sport::class)->findOneBy(['externalType' => 1, 'externalId' => 1]);
        $this->entityManager->getRepository(Tournament::class)->findOneBy(['externalType' => 1, 'externalId' => 86]);
        $this->entityManager->getRepository(Team::class)->findOneBy(['slug' => 'dugo-selo', 'sport' => 1]);
        if (!isset(json_decode($sofaSON, true)['entities'][0]['selector'])) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * Handles processing of the SofaSON as an array and the containing SofaSONObject data. Based on the data entities
     * can be created, deleted or updated.
     *
     * @param array $sofaSON The SofaSON as an array. The processor logic will only expect the array to contain
     *                       the SofaSON declared properties.
     */
    public function persistFromArray(array $sofaSON)
    {
    }
}