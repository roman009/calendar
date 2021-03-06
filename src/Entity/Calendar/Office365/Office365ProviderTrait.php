<?php

namespace App\Entity\Calendar\Office365;

use Symfony\Component\Serializer\Annotation\Groups;

trait Office365ProviderTrait
{
    /**
     * @var string
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    protected $provider = 'office365';

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
