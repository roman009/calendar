<?php

namespace App\Service\Account;

use App\Entity\AccountUser;
use App\Entity\Calendar\CalendarServiceProvider;
use App\Repository\Calendar\Apple\AppleAuthTokenRepository;
use App\Repository\Calendar\Exchange\ExchangeAuthTokenRepository;
use App\Repository\Calendar\Google\GoogleAuthTokenRepository;
use App\Repository\Calendar\Office365\Office365AuthTokenRepository;
use App\Repository\Calendar\Outlook\OutlookAuthTokenRepository;

class CalendarServiceProviderIntegrations
{
    /**
     * @var AppleAuthTokenRepository
     */
    private $appleAuthTokenRepository;
    /**
     * @var GoogleAuthTokenRepository
     */
    private $googleAuthTokenRepository;
    /**
     * @var ExchangeAuthTokenRepository
     */
    private $exchangeAuthTokenRepository;
    /**
     * @var Office365AuthTokenRepository
     */
    private $office365AuthTokenRepository;
    /**
     * @var OutlookAuthTokenRepository
     */
    private $outlookAuthTokenRepository;

    public function __construct(
        AppleAuthTokenRepository $appleAuthTokenRepository,
        GoogleAuthTokenRepository $googleAuthTokenRepository,
        ExchangeAuthTokenRepository $exchangeAuthTokenRepository,
        Office365AuthTokenRepository $office365AuthTokenRepository,
        OutlookAuthTokenRepository $outlookAuthTokenRepository
    ) {
        $this->appleAuthTokenRepository = $appleAuthTokenRepository;
        $this->googleAuthTokenRepository = $googleAuthTokenRepository;
        $this->exchangeAuthTokenRepository = $exchangeAuthTokenRepository;
        $this->office365AuthTokenRepository = $office365AuthTokenRepository;
        $this->outlookAuthTokenRepository = $outlookAuthTokenRepository;
    }

    public function get(AccountUser $accountUser): array
    {
        $calendarIntegrations = [];
        /** @var CalendarServiceProvider $service */
        foreach (CalendarServiceProvider::all() as $service) {
            $calendarIntegrations[] = [
                'service' => $service,
                'token' => $this->{$service->getCode() . 'AuthTokenRepository'}->findOneBy(['accountUser' => $accountUser])
            ];
        }

        return $calendarIntegrations;
    }
}
