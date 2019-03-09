<?php

namespace App\Application\Services\Calendar\Connector\Google;

use App\Application\Services\Calendar\Connector\AbstractConnectorHandler;
use App\Entity\AuthToken;
use App\Entity\GoogleAuthToken;
use App\Entity\GoogleCalendar;
use App\Entity\User;
use App\Repository\GoogleAuthTokenRepository;
use App\Repository\GoogleCalendarRepository;
use Google_Service_Calendar;
use Google_Service_Calendar_CalendarListEntry;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessTokenInterface;

/**
 * Class Google
 */
class GoogleHandler extends AbstractConnectorHandler
{
    public const ALIAS = 'google';
    /**
     * @var AbstractProvider
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

    public function getAuthUrl(User $user): string
    {
        return $this->getProvider()->getAuthorizationUrl(['prompt' => 'consent']);
    }

    private function getProvider(): AbstractProvider
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

    public function fetchAccessToken(string $authCode): AccessTokenInterface
    {
        $token = $this->getProvider()->getAccessToken('authorization_code', ['code' => $authCode]);

        return $token;
    }

    public function persist(AccessTokenInterface $token, User $user): AuthToken
    {
        $googleToken = (new GoogleAuthToken)
            ->setUser($user)
            ->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setScope('https://www.googleapis.com/auth/calendar')
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }

    protected function refreshAccessToken(User $user, AuthToken $googleToken): AuthToken
    {
        $grant = new RefreshToken;

        $token = $this->getProvider()->getAccessToken($grant, ['refresh_token' => $googleToken->getRefreshToken()]);

        $googleToken->setExpires($token->getExpires())
            ->setAccessToken($token->getToken())
            ->setRefreshToken($token->getRefreshToken())
            ->setJson(json_encode($token));

        $this->authTokenRepository->persistAndFlush($googleToken);

        return $googleToken;
    }
}
