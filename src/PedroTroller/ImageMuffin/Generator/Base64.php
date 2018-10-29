<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin\Generator;

use Imagine\Image\ImageInterface;
use PedroTroller\ImageMuffin\Formats;
use PedroTroller\ImageMuffin\Manipulations;

final class Base64
{
    /**
     * @var Content
     */
    private $content;

    public function __construct(Content $content = null)
    {
        $this->content = $content ?: new Content();
    }

    public function generate(ImageInterface $source, Manipulations $manipulations, string $format): string
    {
        $content = $this->content->generate($source, $manipulations, $format);

        return sprintf(
            'data:%s;base64, %s',
            Formats::mimeType($format),
            base64_encode($content)
        );
    }
}
