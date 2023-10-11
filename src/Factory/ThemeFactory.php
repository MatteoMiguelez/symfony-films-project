<?php

namespace App\Factory;

use App\Entity\Theme;

class ThemeFactory
{
    public static function createTheme(array $json): Theme
    {
        $theme = new Theme();
        $theme->setId($json['id'] == null ? '' : $json['id']);
        $theme->setName($json['name'] == null ? '' : $json['name']);
        return $theme;
    }
}