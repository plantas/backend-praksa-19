<?php


namespace AppBundle\Service;


class HtmlTransformer implements TransformerInterface
{

    public function transform(string $input): string
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($input);

        $xpath = new \DOMXPath($dom);
        $matches = $xpath->query("//*[@class='match']");
        foreach ($matches as $match) {
            $teams = $xpath->query("span[@class='team']", $match);
            foreach ($teams as $team) {
                dump($team->nodeValue);
            }

            $result = $xpath->query("*[@class='result']", $match);
            dump($result[0]->nodeValue);
        }
        die('asd');
    }
}