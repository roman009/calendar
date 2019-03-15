<?php

namespace App\Services\Calendar\Connector\Google;

use App\Services\Calendar\Connector\AbstractConnectorAdapter;
use App\Services\Calendar\Connector\OAuthConnectorInterface;
use App\Entity\AccountUser;
use App\Entity\AuthToken;
use App\Entity\GoogleAuthToken;
use App\Repository\GoogleAuthTokenRepository;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessTokenInterface;

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

    public function __construct(GoogleAuthTokenRepository $googleTokenRepository)
    {
        parent::__construct($googleTokenRepository);
    }

    public static function alias(): string
    {
        return self::ALIAS;
    }

    public function getAuthUrl(AccountUser $accountUser): string
    {
        return $this->getProvider()->getAuthorizationUrl(['prompt' => 'consent']);
    }

    protected function getProvider(): AbstractProvider
    {
        if (null === $this->provider) {
            $this->provider = new Google([
                'clientId' => getenv('GOOGLE_CLIENT_ID'),
                'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
                'redirectUri' => 'https://calendar.test.buzila.ro',
                'accessType' => 'offline',
                'scopes' => ['https://www.googleapis.com/auth/calendar'],
            ]);
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
}
