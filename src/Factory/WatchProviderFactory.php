<?php

namespace App\Factory;

use App\Entity\WatchProvider;

class WatchProviderFactory
{
    public static function createWatchProvider(array $watchProviderInfos){
        $watchProvider = new WatchProvider();
        $watchProvider->setDisplayPriority($watchProviderInfos["display_priority"]);
        $watchProvider->setLogoPath('https://image.tmdb.org/t/p/original'.$watchProviderInfos["logo_path"]);
        $watchProvider->setProviderName($watchProviderInfos["provider_name"]);
        return $watchProvider;
    }
}