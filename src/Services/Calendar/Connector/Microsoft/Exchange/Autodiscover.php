<?php

namespace App\Services\Calendar\Connector\Microsoft\Exchange;

class Autodiscover extends \jamesiarmes\PhpEws\Autodiscover
{
    /**
     * @inheritdoc
     */
    public static function getEWS($email, $password, $username = null)
    {
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
}
