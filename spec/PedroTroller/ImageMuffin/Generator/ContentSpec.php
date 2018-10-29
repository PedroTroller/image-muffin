<?php

declare(strict_types=1);

namespace spec\PedroTroller\ImageMuffin\Generator;

use Imagine\Image\ImageInterface;
use PedroTroller\ImageMuffin\Formats;
use PedroTroller\ImageMuffin\Generator\Content;
use PedroTroller\ImageMuffin\Manipulations;
use PhpSpec\ObjectBehavior;

class ContentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Content::class);
    }

    function it_get_the_content_of_an_image_and_returns_it(
        Manipulations $manipulations,
        ImageInterface $source,
        ImageInterface $manipulated
    ) {
        $manipulations->apply($source)->willReturn($manipulated);

        $manipulated->show(Formats::PNG)->willReturn('content');

        $this->generate($source, $manipulations, Formats::PNG)->shouldReturn('content');
    }
}
