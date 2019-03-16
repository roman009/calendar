<?php

namespace App\Entity\Calendar;

class CalendarServiceProvider
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

    /**
     * @return array<CalendarServiceProvider>
     */
    public static function all(): array
    {
        $services = [];

        $services['google'] = (new CalendarServiceProvider('google'))->setName('Google');
        $services['outlook'] = (new CalendarServiceProvider('outlook'))->setName('Outlook');
        $services['office365'] = (new CalendarServiceProvider('office365'))->setName('Office365');
        $services['exchange'] = (new CalendarServiceProvider('exchange'))->setName('Exchange');
        $services['apple'] = (new CalendarServiceProvider('apple'))->setName('Apple');
        ksort($services);

        return $services;
    }

    /**
     * @param string $code
     *
     * @throws \Exception
     *
     * @return CalendarServiceProvider
     */
    public static function get(string $code): CalendarServiceProvider
    {
        $all = self::all();
        if (array_key_exists($code, $all)) {
            return $all[$code];
        }

        throw new \Exception('The service is not supported: ' . $code);
    }
}
