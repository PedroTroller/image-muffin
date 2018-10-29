<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin\Generator;

use Imagine\Image\ImageInterface;
use PedroTroller\ImageMuffin\Formats;
use PedroTroller\ImageMuffin\Manipulations;

final class Content
{
    public function generate(ImageInterface $source, Manipulations $manipulations, string $format): string
    {
        Formats::assertValid($format);

        return (string) $manipulations->apply($source)->show($format);
    }
}
