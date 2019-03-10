<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
use App\Entity\AccountUser;
use App\Entity\User;
use League\OAuth2\Client\Provider\AbstractProvider;
use Stevenmaguire\OAuth2\Client\Provider\Microsoft;

/**
 * Class MicrosoftConnector
 */
abstract class MicrosoftHandler extends AbstractConnectorHandler
{
    /**
     * @var Microsoft
     */
    private $provider;

    protected function getProvider(): AbstractProvider
    {
        if (null === $this->provider) {
            $this->provider = new Microsoft([
                'clientId' => getenv('MICROSOFT_APPLICATION_ID'),
                'clientSecret' => getenv('MICROSOFT_APPLICATION_PASSWORD'),
                'redirectUri' => 'https://calendar.lan/ms-callback',
                'urlAuthorize' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
                'urlAccessToken' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
                'urlResourceOwnerDetails' => 'https://outlook.office.com/api/v2.0/me'
            ]);
        }

        return $this->provider;
    }

    public function getAuthUrl(AccountUser $accountUser): string
    {
        $options = [
            'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
            'scope' => 'offline_access Calendars.Read Calendars.Read.Shared Calendars.ReadWrite Calendars.ReadWrite.Shared' // array or string
        ];

        return $this->getProvider()->getAuthorizationUrl($options);
    }
}
