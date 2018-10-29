<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin\Imagine;

use Exception;
use Imagine;

final class Factory
{
    public function create(): Imagine\Image\ImagineInterface
    {
        $modules = [
            'gd'      => Imagine\Gd\Imagine::class,
            'imagick' => Imagine\Imagick\Imagine::class,
            'gmagick' => Imagine\Gmagick\Imagine::class,
        ];

        foreach ($modules as $module => $class) {
            if (false === \extension_loaded($module)) {
                return new $class();
            }
        }

        throw new Exception(
            sprintf('You need to install %s.', implode('', array_keys($modules)))
        );
    }
}
