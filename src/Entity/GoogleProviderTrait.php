<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

trait GoogleProviderTrait
{
    /**
     * @var string
     * @Groups({"default_api_response_group"})
     */
    protected $provider = 'google';

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     */
    public function setProvider($provider): self
    {
        $this->provider = $provider;

        return $this;
    }
}
