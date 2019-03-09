<?php

namespace App\Application\Services\Calendar\Fetch\Microsoft;

use App\Application\Services\Calendar\Fetch\AbstractFetchHandler;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;
use GuzzleHttp\Exception\RequestException;
use Microsoft\Graph\Graph;

class OutlookHandler extends AbstractFetchHandler
{
    public const ALIAS = 'outlook';
    /**
     * @var Graph
     */
    private $graph;

    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    /**
     * @param AuthToken $token
     *
     * @return array<Calendar>
     */
    protected function fetchCalendars(AuthToken $token): array
    {
        $this->graph->setAccessToken($token->getAccessToken());

        $calendars = [];

        try {
            $calendarsResponse = $this->graph->createRequest('GET', '/me/calendars')
                ->setReturnType(\Microsoft\Graph\Model\Calendar::class)
                ->execute();
        } catch (RequestException $exception) {
            throw new \Exception((string)$exception->getResponse()->getBody());
        }

        dump($calendarsResponse); die();


        return $calendars;
    }

    /**
     * @param AuthToken $token
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $calendars
     * @param string|null $timezone
     *
     * @return array<FreeBusy>
     */
    public function freeBusy(AuthToken $token, \DateTime $startDate, \DateTime $endDate, array $calendars = [], string $timezone = null): array
    {
        // TODO: Implement freeBusy() method.
    }
}