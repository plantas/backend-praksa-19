<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\EventStatus;
use AppBundle\Entity\Goal;
use AppBundle\Entity\SofaSON\SofaSONObject;
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
use Symfony\Component\VarDumper\Cloner\Data;

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
        "gender": "M",
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
        },
        "country": "Croatia"
      },
      "action": "upsert"
    },
    {
      "entity": "AppBundle\\\\Entity\\\\Team",
      "selector": {
        "externalId": 89937
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
        Differentiator $differentiator,
        DataStorageInterface $storage
    )
    {
        $xml = $receiver->receiveXml();

        $json = $transformer->transform($xml);

        $sofaSON = $parser->parse($json); // SofaSON

        $serialized = $sofaSON->jsonSerialize();

        $diff = $differentiator->diff($serialized);

        dump($diff);
        $persister->persistFromArray($diff);

        // store transformer output
        foreach ($serialized['entities'] as $entity) {
            $storage->set($sofaSON->getDataSourceId(), $entity['entity'], $entity['selector'], $sofaSON->getFeedType(), $entity['propertyMap']);
        }

        $event = $em->getRepository('AppBundle:Event')->findOneBy(['id' => 5]);

        $html = '';
        $html .= '<h4>' . $event->getHomeTeam()->getName() . ' - ' . $event->getAwayTeam()->getName() . '</h4>';
        $html .= $event->getHomeScore() . ' : ' . $event->getAwayScore();

        $html .= '<ul>';
        /** @var Goal $goal */
        foreach ($event->getGoals() as $goal) {
            $html .= '<li>' . $goal->getMinute() . '\' - ' . $goal->getHomeScore() . ':' . $goal->getAwayScore() . ' by ' . $goal->getPlayer();
            if ($goal->getAssist()) {
                $html .= ' assisted by ' . $goal->getAssist();
            }
            $html .= '</li>';
        }

        $html .= '</ul>';

        return new Response('Saved successfully' . $html);
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
        $status->setCode(1)
            ->setType('Started')
            ->setDescription('Match has started');

        $goal = new Goal();
        $goal->setExternalId(1)
            ->setExternalType(1)
            ->setHomeScore(2)
            ->setAwayScore(0)
            ->setPlayer('Test Scorer')
            ->setAssist('Test Asistent')
            ->setMinute(40)
        ;

        /*
        $event = new Event();
        $event->setExternalId(1)
            ->setExternalType(1)
            ->setSport($sport)
            ->setTournament($tournament)
            ->setStatus($status)
            ->setStartDate(new \DateTime())
            ->setHomeTeam($homeTeam)
            ->setAwayTeam($awayTeam)
            ->setHomeScore(0)
            ->setAwayScore(0);
*/

        /** @var Event $event */
        $event = $em->getRepository('AppBundle:Event')->findOneBy(['externalId' => 1, 'externalType' => 1]);

        if ($event) {
            $goals = $event->getGoals();
            foreach ($goals as $goal) {
                dump($goal);
            }
            die;

            /*
            $event->addGoal($goal);
            $em->persist($event);
            $em->flush();*/
        } else {
            die ('Event does not exists');
        }


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

        dump('Diff', $data);die;

    }

    /**
     * @Route("/foo")
     * @param Request $request
     */
    public function foo(Request $request)
    {
        $kernel = $this->container->get('kernel');
        dump($kernel->getProjectDir());die;
    }
}
