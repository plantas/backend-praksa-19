<?php


namespace AppBundle\Service;


class Receiver
{

    public function receiveXml()
    {
        return <<<XML
<xml version="1.0" encoding="UTF-8">
<commentary season_id="2020" comp_id="12" home_id="501436" away_id="33763">
    <message id="1" comment="Goal 1:0" time="20 min" scorer="Mario Mandzukic" />
    <message id="2" comment="Goal 2:0" time="30 min" scorer="Ivan Rakitic" />
    <message id="3" comment="Goal 2:1" time="65 min" scorer="Cristiano Ronaldo" />
</commentary>
</xml>
XML;


//    <message id="4" comment="Goal 2:2" time="67 min" scorer="André Silva" assist="Cristiano Ronaldo" />
    }

}