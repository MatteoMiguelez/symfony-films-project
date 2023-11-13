<?php

namespace App\Entity;

class WatchProvider
{
    private ?string $logo_path;

    private ?string $provider_name;

    private ?int $display_priority;

    /**
     * @return string|null
     */
    public function getLogoPath(): ?string
    {
        return $this->logo_path;
    }

    /**
     * @param string|null $logo_path
     */
    public function setLogoPath(?string $logo_path): void
    {
        $this->logo_path = $logo_path;
    }

    /**
     * @return string|null
     */
    public function getProviderName(): ?string
    {
        return $this->provider_name;
    }

    /**
     * @param string|null $provider_name
     */
    public function setProviderName(?string $provider_name): void
    {
        $this->provider_name = $provider_name;
    }

    /**
     * @return int|null
     */
    public function getDisplayPriority(): ?int
    {
        return $this->display_priority;
    }

    /**
     * @param int|null $display_priority
     */
    public function setDisplayPriority(?int $display_priority): void
    {
        $this->display_priority = $display_priority;
    }
}