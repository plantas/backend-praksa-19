<?php


namespace AppBundle\Service;


class XmlTransformer implements TransformerInterface
{

    public function transform(string $input): string
    {
        $xml = new \SimpleXMLElement($input);

        $commentary = $xml->xpath('commentary');

        // base attributes
        $data = $this->getCommentaryAttributes($commentary[0]);

        $messages = $xml->xpath('commentary/message');
        foreach ($messages as $message) {
            $data['messages'][] = $this->getMessage($message);
        }

        return json_encode($data);
    }

    private function getCommentaryAttributes(\SimpleXMLElement $element): ?array
    {
        // moze biti dio configa
        $lookFor = [
            'comp_id' => 'competitionId',
            'home_id' => 'homeTeamId',
            'away_id' => 'awayTeamId'
        ];

        $data = [];

        foreach ($lookFor as $key => $target) {
            $value = (string) $element[$key];

            if ($value) {
                $data[$target] = $value;
            } else {
                throw new \Exception("Season id cannot be found");
            }
        }

        return $data;
    }

    private function getMessage(\SimpleXMLElement $element): ?array
    {
        $data = [];

        $lookFor = [
            'id'        => 'id',
            'comment'   => 'comment',
            'time'      => 'time',
            'scorer'    => 'player',
            'assist'    => 'assist'
        ];

        foreach ($lookFor as $key => $target) {
            $data[$target] = isset($element[$key]) ? (string) $element[$key] : '';
        }

        return $data;
    }

}