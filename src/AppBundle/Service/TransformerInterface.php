<?php


namespace AppBundle\Service;


interface TransformerInterface
{

    public function transform(string $input): string;

}