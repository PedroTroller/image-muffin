<?php

namespace PedroTroller\ImageMuffin;

use PedroTroller\ImageMuffin\Image;
use Symfony\Component\Finder\Finder;
use Faker\Provider\Base as Faker;

class Selector
{
    const EXT_JPG = 'jpg';

    /**
     * @var string
     */
    private $folder;

    /**
     * @param string $folder
     */
    public function __construct($folder, Finder $finder = null)
    {
        $this->folder = $folder;
        $this->finder = $finder ?: (new Finder());
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $extension
     *
     * @return Image
     */
    public function select($width, $height, $extension)
    {
        $folder = $this->buildFolderPath($width, $height, $extension);

        $files = $this
            ->finder
            ->in($folder)
            ->name(sprintf('*.%s', $extension))
            ->files()
        ;

        $images = [];

        foreach ($files as $file) {
            $images[] = new Image($file->getRealPath());
        }

        return $images;
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $extension
     * @return string
     */
    private function buildFolderPath($width, $height, $extension)
    {

        if (null === $disposition = Image::resolveDisposition($width, $height)) {
            $disposition = Faker::randomElement([Image::LANDSCAPE, Image::PORTRAIT]);
        }

        return sprintf('%s/%s/%s', $this->folder, $disposition, $extension);
    }
}
