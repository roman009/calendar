<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

trait ExchangeProviderTrait
{
    /**
     * @var string
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    protected $provider = 'exchange';

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     *
     * @return self
     */
    public function setProvider($provider): self
    {
        $this->provider = $provider;

        return $this;
    }
}