<?php

namespace PedroTroller\ImageMuffin\Formatter;

use PedroTroller\ImageMuffin\Image;
use Symfony\Component\Console\Output\OutputInterface;

class Filename
{
    /**
     * {@inheritdoc}
     */
    public function output(Image $image, OutputInterface $output)
    {
        $output->write($image->getPath());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filename';
    }
}
