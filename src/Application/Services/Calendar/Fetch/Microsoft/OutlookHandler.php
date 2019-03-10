<?php

namespace App\Application\Services\Calendar\Fetch\Microsoft;

use App\Application\Services\Calendar\Fetch\AbstractFetchHandler;
use App\Application\Services\Calendar\Fetch\Microsoft\CustomModel\Calendar as CustomCalendar;
use App\Entity\AuthToken;
use App\Entity\Calendar;
use App\Entity\FreeBusy;
use App\Entity\OutlookCalendar;
use App\Entity\OutlookFreeBusy;
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
     * @throws \Microsoft\Graph\Exception\GraphException
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

        /** @var \Microsoft\Graph\Model\Calendar $calendar */
        foreach ($calendarsResponse as $calendar) {
            dump($calendar);
            $outlookCalendar = new OutlookCalendar;
            $outlookCalendar
                ->setOwnerEmailAddress($calendar->getOwner()->getAddress())
//                ->setDescription()
                ->setSummary($calendar->getName())
//                ->setTimezone($calendar->get)
                ->setPrimary($calendar->getCanEdit())
                ->setCalendarId($calendar->getId());
            $calendars[] = $outlookCalendar;
        }

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
        $this->graph->setAccessToken($token->getAccessToken());
        $this->graph->setApiVersion('beta');

        $freeBusyList = [];

        $requestBody = [
            'Schedules' => array_unique(array_map(function (OutlookCalendar $calendar) {
                return $calendar->getOwnerEmailAddress();
            }, $calendars)),
            'StartTime' => [
                'dateTime' => $startDate->format(DATE_ATOM),
                'timeZone' => $timezone
            ],
            'EndTime' => [
                'dateTime' => $endDate->format(DATE_ATOM),
                'timeZone' => $timezone
            ],
            'availabilityViewInterval' => '15'
        ];

        try {
            $freeBusyResponse = $this->graph->createRequest('POST', '/me/calendar/getschedule')
                ->attachBody($requestBody)
                ->setReturnType(CustomCalendar::class)
                ->execute();
        } catch (\Exception $e) {
            throw $e;
        }

        /** @var CustomCalendar $calendar */
        foreach ($freeBusyResponse as $calendar) {
            foreach ($calendar->getScheduleItems() as $busyTimePeriod) {
                $freeBusy = (new OutlookFreeBusy)
                    ->setCalendar($calendar->getScheduleId())
                    ->setStart(new \DateTime($busyTimePeriod['start']['dateTime']))
                    ->setEnd(new \DateTime($busyTimePeriod['end']['dateTime']))
                    ->setType($busyTimePeriod['status'] === 'busy' ? FreeBusy::TYPE_BUSY : FreeBusy::TYPE_FREE);
                $freeBusyList[] = $freeBusy;
            }
        }

        return $freeBusyList;
    }
}
