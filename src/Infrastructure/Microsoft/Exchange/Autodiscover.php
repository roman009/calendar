<?php

namespace App\Infrastructure\Microsoft\Exchange;

class Autodiscover extends \jamesiarmes\PhpEws\Autodiscover
{
    protected static $server;

    /**
     * @inheritdoc
     */
    public static function getEWS($email, $password, $username = null, string $server = null)
    {
        self::$server = $server;
        $auto = new Autodiscover($email, $password, $username);
        return $auto->newEWS();
    }

    /**
     * @inheritdoc
     */
    public function newEWS()
    {
        // Discovery not yet attempted.
        if ($this->discovered === null) {
            $this->discover();
        }

        // Discovery not successful.
        if ($this->discovered === false) {
            return false;
        }

        $server = false;
        $version = null;

        // Pick out the host from the EXPR (Exchange RPC over HTTP).
        foreach ($this->discovered['Account']['Protocol'] as $protocol) {
            if (
                ($protocol['Type'] == 'EXCH' || $protocol['Type'] == 'EXPR')
                && isset($protocol['ServerVersion'])
            ) {
                if ($version === null) {
                    $sv = $this->parseServerVersion($protocol['ServerVersion']);
                    if ($sv !== false) {
                        $version = $sv;
                    }
                }
            }

            if ($protocol['Type'] == 'EXPR' && isset($protocol['Server'])) {
                $server = $protocol['Server'];
            }
        }

        if ($server) {
            if ($version === null) {
                // EWS class default.
                $version = Client::VERSION_2007;
            }
            return new Client(
                $server,
                (!empty($this->username) ? $this->username : $this->email),
                $this->password,
                $version
            );
        }

        return false;
    }

    /**
     * Execute the full discovery chain of events in the correct sequence
     * until a valid response is received, or all methods have failed.
     *
     * @return integer
     *   One of the AUTODISCOVERED_VIA_* constants.
     *
     * @throws \RuntimeException
     *   When all autodiscovery methods fail.
     */
    public function discover()
    {
        $result = $this->tryTLD();

        if ($result === false) {
            $result = $this->trySubdomain();
        }

        if ($result === false) {
            $result = $this->trySubdomainUnauthenticatedGet();
        }

        if ($result === false) {
            $result = $this->trySRVRecord();
        }

        if (null !== self::$server) {
            $this->tld = self::$server;

            if ($result === false) {
                $result = $this->trySubdomain();
            }

            if ($result === false) {
                $result = $this->trySubdomainUnauthenticatedGet();
            }

            if ($result === false) {
                $result = $this->trySRVRecord();
            }
            dump($result);
        }

        if ($result === false) {
            throw new \RuntimeException('Autodiscovery failed.');
        }

        return $result;
    }
}
