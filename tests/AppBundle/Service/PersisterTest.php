<?php


namespace AppBundle\Service;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoryRepository;
use AppBundle\Repository\SportRepository;
use AppBundle\Repository\TeamRepository;
use AppBundle\Repository\TournamentRepository;
use AppBundle\Entity\Sport;
use AppBundle\Entity\Team;
use AppBundle\Entity\Tournament;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;


class PersisterTest extends TestCase
{
    protected $managerRegistry;
    protected $logger;
    protected $sofaSONService;

    protected $entityManager;
    protected $footballEvent;

    protected $sofaSON_JSON_deleteEvent = <<<JSON
{
	"dataSourceId" : 1,
	"feedType" : "livescore",
	"entities" : [
		{
			"entity" : "AppBundle\\\\Entity\\\\Team",
			"selector" : {
				"externalId" : 3457845
			},
			"action" : "delete"
		}
	]
}
JSON;

    protected $sofaSON_JSON_createTeam = <<<JSON
{
	"dataSourceId" : 1,
	"feedType" : "livescore",
	"entities" : [
		{
            "entity" : "AppBundle\\\\Entity\\\\Team",
            "selector" : {
                "externalId" : 89936
            },
            "propertyMap" : {
                "name" : "NK Dugo Selo",
                "gender" : "M",
                "sport" : {
                    "entity" : "AppBundle\\\\Entity\\\\Sport",
                    "selector" : {
                        "externalId" : 1
                    },
                    "action" : "update"
                },
                "category" : {
                    "entity" : "AppBundle\\\\Entity\\\\Category",
                    "selector" : {
                        "externalId" : 1
                    },
                    "action" : "update"
                }
            },
            "action" : "upsert"
		}
	]
}
JSON;

    protected $sofaSON_JSON_noSelector = <<<JSON
{
	"dataSourceId" : 1,
	"feedType" : "livescore",
	"entities" : [
		{
			"entity" : "AppBundle\\\\Entity\\\\Team",
            "propertyMap" : {
                "name" : "NK Dugo Selo",
                "gender" : "M",
                "sport" : {
                    "entity" : "AppBundle\\\\Entity\\\\Sport",
                    "selector" : {
                        "externalId" : 1
                    },
                    "action" : "update"
                },
                "category" : {
                    "entity" : "AppBundle\\\\Entity\\\\Category",
                    "selector" : {
                        "externalId" : 1
                    },
                    "action" : "update"
                }
            },
			"action" : "update"
		}
	]
}
JSON;

    protected $sofaSON_JSON_primitiveSelectors = <<<JSON
{
    "dataSourceId" : 1,
    "feedType" : "livescore",
    "entities" : [
        {
            "entity" : "AppBundle\\\\Entity\\\\Team",
            "selector" : {
                "slug" : "dugo-selo",
                "sport" : 1
            },
            "action" : "update"
        }
    ]
}
JSON;

    protected $sofaSON_JSON_objectSelector = <<<JSON
{
    "dataSourceId" : 1,
    "feedType" : "livescore",
    "entities" : [
        {
            "entity" : "AppBundle\\\\Entity\\\\Team",
            "selector" : {
                "slug" : "dugo-selo",
                "sport" : {
                    "entity" : "AppBundle\\\\Entity\\\\Sport",
                    "selector" : {
                        "externalId" : 1
                    },
                    "action" : "update"
                },
                "tournament" : {
                    "entity" : "AppBundle\\\\Entity\\\\Tournament",
                    "selector" : {
                        "externalId" : 86
                    },
                    "action" : "update"
                }
            },
            "action" : "update"
        }
    ]
}
JSON;


    protected function setUp(): void
    {
        parent::setUp();

        // Entity mocks
        $sport = $this->getMockBuilder(Sport::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSlug'])
            ->getMock();

        $sport->expects($this->any())
            ->method('getSlug')
            ->willReturn('football');

        $category = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tournament = $this->getMockBuilder(Tournament::class)
            ->disableOriginalConstructor()
            ->getMock();

        $homeTeam = $this->getMockBuilder(Team::class)
            ->disableOriginalConstructor()
            ->setMethods(['setName', 'setGender'])
            ->getMock();

        $awayTeam = $this->getMockBuilder(Team::class)
            ->disableOriginalConstructor()
            ->setMethods(['setName', 'setGender'])
            ->getMock();

        $noExternalIdTeam = $this->getMockBuilder(Team::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Repositories mocks

        $sportRepo = $this->getMockBuilder(SportRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByMappedId', 'findOneBy'])
            ->getMock();

        $sportRepo->expects($this->any())
            ->method('findByMappedId')->willReturn($sport);

        $categoryRepo = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByMappedId'])
            ->getMock();

        $categoryRepo->expects($this->any())
            ->method('findByMappedId')->willReturn($category);

        $tournamentRepo = $this->getMockBuilder(TournamentRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByMappedId', 'findOneBy'])
            ->getMock();

        $tournamentRepo->expects($this->any())
            ->method('findByMappedId')->willReturn($tournament);

        $teamRepo = $this->getMockBuilder(TeamRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findByMappedId', 'findOneBy'])
            ->getMock();

        $teamArgToReturnValueMap = [
            [1, 1, $homeTeam],
            [1, 30, $awayTeam],
            [1, 89936, null],
        ];

        $teamRepo->expects($this->any())
            ->method('findByMappedId')
            ->will($this->returnValueMap($teamArgToReturnValueMap));

        $teamRepo->expects($this->any())
            ->method('findOneBy')
            ->willReturn($noExternalIdTeam);

        // EntityManager mock
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'flush', 'getRepository', 'remove', 'getClassMetadata'])
            ->getMock();

        $repositoryArgToReturnValueMap = [
            [Sport::class, $sportRepo],
            [Category::class, $categoryRepo],
            [Tournament::class, $tournamentRepo],
            [Team::class, $teamRepo],
        ];

        $this->entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValueMap($repositoryArgToReturnValueMap));

        // Persister constructor parameters mock
        $this->managerRegistry = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->setMethods(['getManager'])
            ->getMockForAbstractClass();

        $this->managerRegistry->expects($this->any())->method('getManager')->willReturn($this->entityManager);
    }

    public function testEntityDelete()
    {
        $this->entityManager->expects($this->once())->method('remove');

        $persister = new Persister($this->managerRegistry);
        $persister->persistFromJSON($this->sofaSON_JSON_deleteEvent);
    }

    public function testEntityCreate()
    {
        $this->entityManager->expects($this->atLeastOnce())->method('persist');
        $this->entityManager->expects($this->atLeastOnce())->method('flush');

        $persister = new Persister($this->managerRegistry);
        $persister->persistFromJSON($this->sofaSON_JSON_createTeam);
    }

    public function testNoSelectorException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $persister = new Persister($this->managerRegistry);
        $persister->persistFromJSON($this->sofaSON_JSON_noSelector);
    }

    public function testPrimitiveSelectors()
    {
        $teamRepository = $this->entityManager->getRepository(Team::class);
        $teamRepository->expects($this->once())->method('findOneBy')->with(['slug' => 'dugo-selo', 'sport' => 1]);

        $persister = new Persister($this->managerRegistry);
        $persister->persistFromJSON($this->sofaSON_JSON_primitiveSelectors);
    }

    public function testObjectSelectors()
    {
        $teamRepository       = $this->entityManager->getRepository(Team::class);
        $sportRepository      = $this->entityManager->getRepository(Sport::class);
        $tournamentRepository = $this->entityManager->getRepository(Tournament::class);

        $sport      = $sportRepository->findByMappedId(1, 1);
        $tournament = $tournamentRepository->findByMappedId(1, 86);

        $sportRepository->expects($this->once())->method('findOneBy')->with(['externalType' => 1, 'externalId' => 1]);
        $tournamentRepository->expects($this->once())->method('findOneBy')->with(['externalType' => 1, 'externalId' => 86]);
        $teamRepository->expects($this->once())->method('findOneBy')->with(['slug' => 'dugo-selo', 'sport' => $sport, 'tournament' => $tournament]);

        $persister = new Persister($this->managerRegistry);
        $persister->persistFromJSON($this->sofaSON_JSON_objectSelector);
    }
}
