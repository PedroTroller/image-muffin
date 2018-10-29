<?php

declare(strict_types=1);

namespace spec\PedroTroller\ImageMuffin\Orientation;

use PedroTroller\ImageMuffin\Orientation\ImageDetector;
use PhpSpec\ObjectBehavior;

class ImageDetectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ImageDetector::class);
    }
}
