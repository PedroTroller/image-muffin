<?php

namespace PedroTroller\ImageMuffin;

class Image
{
    const SQUARE = null;
    const PORTRAIT = 'landscape';
    const LANDSCAPE = 'portrait';

    /**
     * @var array
     */
    private $cache;

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->cache = getimagesize($path);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->cache[0];
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->cache[1];
    }

    /**
     * @return int
     */
    public function getPixels()
    {
        return $this->getHeight() * $this->getWidth();
    }

    /**
     * @return int
     */
    public function getDisposition()
    {
        return self::resolveDisposition($this->getWidth(), $this->getHeight());
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return string|null
     */
    public static function resolveDisposition($width, $height)
    {
        switch (true) {
            case ($width > $height):
                return self::LANDSCAPE;
            case ($height > $width):
                return self::PORTRAIT;
            default:
                return self::SQUARE;
        }
    }
}
