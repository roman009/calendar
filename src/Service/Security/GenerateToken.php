<?php

namespace App\Service\Security;

class GenerateToken
{
    /**
     * @param int $length
     *
     * @throws \Exception
     *
     * @return string
     */
    public function __invoke(int $length = 32): string
    {
        if (function_exists('random_bytes')) {
            $random = bin2hex(random_bytes($length / 2));
        } elseif (function_exists('mcrypt_create_iv')) {
            $random = bin2hex(mcrypt_create_iv($length / 2, MCRYPT_DEV_URANDOM));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $random = bin2hex(openssl_random_pseudo_bytes($length));
        } else {
            throw new \Exception('No secure way to generate random token');
        }

        return $random;
    }
}
