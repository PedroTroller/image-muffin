<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use RuntimeException;

final class Manipulations
{
    /**
     * @var int|null
     */
    private $width;

    /**
     * @var int|null
     */
    private $height;

    public function __construct(int $width = null, int $height = null)
    {
        $this->width  = $width;
        $this->height = $height;
    }

    public function apply(ImageInterface $image): ImageInterface
    {
        if (null === $this->width && null === $this->height) {
            return $image;
        }

        switch (true) {
            case null !== $this->width && null !== $this->height:
                $box = new Box($this->width, $this->height);

                break;
            case null !== $this->width && null === $this->height:
                $box = $image->getSize()->widen($this->width);

                break;
            case null !== $this->height && null === $this->width:
                $box = $image->getSize()->heighten($this->height);

                break;
            default:
                throw new RuntimeException('Manipulation appliance faillure.');
        }

        return $image->resize($box);
    }
}
