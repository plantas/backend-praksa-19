<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\EventStatus;
use AppBundle\Service\DataStorageInterface;
use AppBundle\Service\DemoParser;
use AppBundle\Service\Differentiator;
use AppBundle\Service\MyParser;
use AppBundle\Service\Parser;
use AppBundle\Service\Persister;
use AppBundle\Service\Receiver;
use AppBundle\Service\XmlTransformer;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Diff\Diff;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    private $input = <<<JSON
{
  "dataSourceId": 1,
  "feedType": "livescore",
  "entities": [
    {
      "entity": "AppBundle\\\\Entity\\\\Team",
      "selector": {
        "externalId": 89936
      },
      "propertyMap": {
        "name": "NK Dugo Selo",
        "gender": "F",
        "new": "test",
        "sport": {
          "entity": "AppBundle\\\\Entity\\\\Sport",
          "selector": {
            "name": "2",
            "externalId": 1
          }
        },
        "category": {
          "entity": "AppBundle\\\\Entity\\\\Category",
          "selector": {
            "externalId": 1
          }
        }
      },
      "action": "upsert"
    },
    {
      "entity": "AppBundle\\\\Entity\\\\Team",
      "selector": {
        "externalId": 11111
      },
      "action": "delete"
    },
    {
      "entity": "AppBundle\\\\Entity\\\\Team",
      "selector": {
        "externalId": 89937
      },
      "action": "delete"
    },
    {
      "entity": "AppBundle\\\\Entity\\\\Team",
      "selector": {
        "externalId": 89
      },
      "action": "delete"
    }
  ]
}
JSON;

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Persister $persister
     * @param MyParser $parser
     * @param XmlTransformer $transformer
     * @param Receiver $receiver
     * @param Differentiator $differentiator
     * @return void
     */
    public function indexAction(
        Request $request,
        EntityManagerInterface $em,
        Persister $persister,
        MyParser $parser,
        XmlTransformer $transformer,
        Receiver $receiver,
        Differentiator $differentiator
    )
    {
        $xml = $receiver->receiveXml();

        $json = $transformer->transform($xml);

        $sofaSON = $parser->parse($json);

        $diff = $differentiator->diff($sofaSON->jsonSerialize());

        $persister->persistFromArray($diff);

        die;

    }

    /**
     * @Route("/persist")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @throws \Exception
     */
    public function persist(Request $request, EntityManagerInterface $em)
    {

        $tournament = $em->getRepository('AppBundle:Tournament')->findOneBy(['externalId' => 1]);
        $sport = $em->getRepository('AppBundle:Sport')->findOneBy(['externalId' => 1]);

        $homeTeam = $em->getRepository('AppBundle:Team')->findOneBy([
            'id' => 298067
        ]);
        $awayTeam = $em->getRepository('AppBundle:Team')->findOneBy([
            'id' => 319591
        ]);

        $status = new EventStatus();
        $status->setCode(1);
        $status->setType('Started');
        $status->setDescription('Match has started');

        $event = new Event();
        $event->setExternalId(1);
        $event->setExternalType(1);
        $event->setSport($sport);
        $event->setTournament($tournament);
        $event->setStatus($status);
        $event->setStartDate(new \DateTime());
        $event->setHomeTeam($homeTeam);
        $event->setAwayTeam($awayTeam);
        $event->setHomeScore(0);
        $event->setAwayScore(0);

//        $em->persist($event);
//        $em->flush();

        //$em->getRepository('AppBundle:Event');

        return new Response('Saved');
    }

    /**
     * @Route("/diff")
     * @param Request $request
     * @param DataStorageInterface $storage
     * @param Differentiator $differentiator
     * @return Response
     */
    public function diff(Request $request, DataStorageInterface $storage, Differentiator $differentiator)
    {
        /*
        $sofaSON = SofaSONFactory::fromJson($this->input);
        $sofaSON = json_decode($this->input, true);
        $storage = new FilesystemDataStorage();
        foreach ($sofaSON['entities'] as $e) {
            $storage->set($sofaSON['dataSourceId'], $e['entity'], $e['selector'], $sofaSON['feedType'], $e['propertyMap'] ?? []);
        }
        */

        $data = $differentiator->diff(json_decode($this->input, true));

        dump($data);die;

    }
}
