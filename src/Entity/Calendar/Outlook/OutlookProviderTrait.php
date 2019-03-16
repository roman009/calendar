<?php

namespace App\Entity\Calendar\Outlook;

use Symfony\Component\Serializer\Annotation\Groups;

trait OutlookProviderTrait
{
    /**
     * @var string
     * @Groups({"default_api_response_group", "default_api_write_group"})
     */
    protected $provider = 'outlook';

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
