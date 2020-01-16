<?php


namespace AppBundle\Service;


use AppBundle\Entity\SofaSON\SofaSON;

interface XmlParserInterface
{

    public function parse(string $input): SofaSON;

}