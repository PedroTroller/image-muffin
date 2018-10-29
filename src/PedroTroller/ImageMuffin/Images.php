<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin;

use Generator;
use Imagine\Imagick\Imagine;
use IteratorAggregate;
use Symfony\Component\Finder\Finder;

final class Images implements IteratorAggregate
{
    public function getIterator(): Generator
    {
        $root    = (string) realpath(sprintf('%s/../../../fixtures', __DIR__));
        $imagine = new Imagine();

        $finder = (new Finder())
            ->in($root)
        ;

        foreach (Formats::all() as $format) {
            $finder->name(sprintf('*.%s', $format));
        }

        foreach ($finder as $fileInfo) {
            yield $imagine->open($fileInfo->getPathname());
        }
    }

    public function landscape(): Generator
    {
        foreach ($this as $image) {
            $box = $image->getSize();

            if ($box->getWidth() > $box->getHeight()) {
                yield $image;
            }
        }
    }

    public function portrait(): Generator
    {
        foreach ($this as $image) {
            $box = $image->getSize();

            if ($box->getWidth() < $box->getHeight()) {
                yield $image;
            }
        }
    }
}
