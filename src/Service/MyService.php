<?php

namespace App\Service;


class MyService
{

    private function getStateArray()
    {
        return ['Niezapłacona', 'Windykowana', 'U Prawnika', 'Zapłacona', 'Sprawa sporna'];
    }

    public function formatStatesResponse($dbResponse)
    {
        $stany = $this->getStateArray();
        foreach ($dbResponse as $format) {
            $format->setStan($stany[$format->getStan()]);
        }

        return $dbResponse;
    }

}