<?php

namespace App\Service\Calendar\Connector\Microsoft;

use App\Entity\AccountUser;
use App\Service\Calendar\Connector\AbstractConnectorAdapter;
use League\OAuth2\Client\Provider\AbstractProvider;
use Stevenmaguire\OAuth2\Client\Provider\Microsoft;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class MicrosoftAdapter
 */
abstract class MicrosoftAdapter extends AbstractConnectorAdapter
{
    /**
     * @var Microsoft
     */
    private $provider;

    protected function getProvider(): AbstractProvider
    {
        if (null === $this->provider) {
            $this->provider = new Microsoft($this->getMainProviderOptions());
        }

        return $this->provider;
    }

    public function getAuthUrl(AccountUser $accountUser): string
    {
        $options = [
            'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
            'scope' => 'offline_access Calendars.Read Calendars.Read.Shared Calendars.ReadWrite Calendars.ReadWrite.Shared' // array or string
        ];

        return $this->getAuthProviderWithUrl($accountUser)->getAuthorizationUrl($options);
    }

    protected function getMainProviderOptions(): array
    {
        return [
            'clientId' => getenv('MICROSOFT_APPLICATION_ID'),
            'clientSecret' => getenv('MICROSOFT_APPLICATION_PASSWORD'),
            'urlAuthorize' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            'urlAccessToken' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://outlook.office.com/api/v2.0/me',
            'redirectUri' => $this->router->generate(
                'integration-calendar-connect-oauth-callback-handler',
                ['providerName' => $this->alias()],
                UrlGeneratorInterface::ABSOLUTE_URL
            )
        ];
    }

    private function getAuthProviderWithUrl(AccountUser $accountUser): AbstractProvider
    {
        return new Microsoft($this->getMainProviderOptions());
    }

    public function getAuthCodeFromRequest(Request $request): string
    {
        return $request->get('code');
    }
}
