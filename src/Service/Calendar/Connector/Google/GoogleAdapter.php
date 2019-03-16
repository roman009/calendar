<?php

namespace App\Service\Calendar\Connector\Google;

use App\Entity\AccountUser;
use App\Entity\Calendar\AuthToken;
use App\Entity\Calendar\Google\GoogleAuthToken;
use App\Repository\Calendar\Google\GoogleAuthTokenRepository;
use App\Service\Calendar\Connector\AbstractConnectorAdapter;
use App\Service\Calendar\Connector\OAuthConnectorInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class Google
 */
class GoogleAdapter extends AbstractConnectorAdapter implements OAuthConnectorInterface
{
    public const ALIAS = 'google';
    /**
     * @var Google
     */
    private $provider;

    public function __construct(GoogleAuthTokenRepository $googleTokenRepository, RouterInterface $router)
    {
        parent::__construct($googleTokenRepository, $router);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function getAuthUrl(AccountUser $accountUser): string
    {
        $options = [
            'prompt' => 'consent'
        ];

        return $this->getAuthProviderWithUrl($accountUser)->getAuthorizationUrl($options);
    }

    protected function getProvider(): AbstractProvider
    {
        if (null === $this->provider) {
            $this->provider = new Google($this->getMainProviderOptions());
        }

        return $this->provider;
    }

    public function persist(AccessTokenInterface $token, AccountUser $accountUser): AuthToken
    {
        $googleToken = (new GoogleAuthToken)
            ->setAccountUser($accountUser)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setScope('https://www.googleapis.com/auth/calendar')
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }

    public function validate(string $username, string $password): bool
    {
        throw new \Exception('This shouldn\'t be called here');
    }

    public function saveUsernamePasswordToken(AccountUser $accountUser, string $username, string $password)
    {
        throw new \Exception('This shouldn\'t be called here');
    }

    private function getAuthProviderWithUrl(AccountUser $accountUser): AbstractProvider
    {
        return new Google($this->getMainProviderOptions());
    }

    protected function getMainProviderOptions(): array
    {
        return [
            'clientId' => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'accessType' => 'offline',
            'scopes' => ['https://www.googleapis.com/auth/calendar'],
            'redirectUri' => $this->router->generate(
                'integration-calendar-connect-oauth-callback-handler',
                ['providerName' => $this->alias()],
                UrlGeneratorInterface::ABSOLUTE_URL
            ),
        ];
    }

    public function getAuthCodeFromRequest(Request $request): string
    {
        return $request->get('code');
    }
}
