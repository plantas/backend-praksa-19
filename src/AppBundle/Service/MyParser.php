<?php


namespace AppBundle\Service;


use AppBundle\Entity\Event;
use AppBundle\Entity\Goal;
use AppBundle\Entity\SofaSON\SofaSON;
use AppBundle\Entity\SofaSON\SofaSONObject;

class MyParser implements XmlParserInterface
{

    //"{"competitionId":"12","homeTeamId":"501436","awayTeamId":"33763","messages":[{"id":"1","comment":"Goal 1:0","time":"20 min"}]}"

    public function parse(string $json): SofaSON
    {
        $data = json_decode($json, true);

        $sofaSON = new SofaSON(1, 'Source.com');

        // hardcoded so far
        $event = SofaSONObject::fromEntityAndSelector(
            Event::class,
            ['externalId' => 1, 'externalType' => 1]
        );

        foreach ($data['messages'] as $message) {

            $goals = substr($message['comment'], strlen('Goal '));
            list($homeScore, $awayScore) = explode(':', $goals);
            $minute = intval($message['time']);

            $sofaSONEntity = SofaSONObject::fromEntitySelectorAndPropertyMap(
                Goal::class,
                [
                    'event'         => $event,
                    'externalId'    => intval($message['id']),
                    'externalType'  => 1,
                ],
                [
                    'event'         => $event,
                    'externalId'    => intval($message['id']),
                    'externalType'  => 1,
                    'homeScore'     => $homeScore,
                    'awayScore'     => $awayScore,
                    'minute'        => $minute,
                    'player'        => $message['player'],
                    'assist'        => trim($message['assist'])
                ]
            );
            $sofaSONEntity->setAction(SofaSONObject::ACTION_UPSERT);

            $sofaSON->addEntity($sofaSONEntity);
        }

        // update event score
        $event->setPropertyMap([
            'homeScore' => $homeScore,
            'awayScore' => $awayScore
        ]);
        $sofaSON->addEntity($event);

        return $sofaSON;
    }

}
