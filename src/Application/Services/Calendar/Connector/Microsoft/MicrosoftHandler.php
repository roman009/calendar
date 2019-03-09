<?php

namespace App\Application\Services\Calendar\Connector\Microsoft;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
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
            ]);
        }

        return $this->provider;
    }

    public function getAuthUrl(User $user): string
    {
        return $this->getProvider()->getAuthorizationUrl();
    }
}
