<?php

namespace App\Entity;

class Service
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public static function all(): array
    {
        $services = [];

        $services['google'] = (new Service('google'))->setName('Google');
        $services['outlook'] = (new Service('outlook'))->setName('Outlook');
        $services['office365'] = (new Service('office365'))->setName('Office365');
        $services['exchange'] = (new Service('exchange'))->setName('Exchange');

        return $services;
    }

    public static function get(string $code): Service
    {
        $all = self::all();
        if (array_key_exists($code, $all)) {
            return $all[$code];
        }

        throw new \Exception('The service is not supported: ' . $code);
    }
}