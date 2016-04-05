<?php

namespace PedroTroller\ImageMuffin;

use Symfony\Component\Console\Output\OutputInterface;
use PedroTroller\ImageMuffin\Image;

class Formatter
{
    /**
     * @param Image $image
     * @param OutputInterface $output
     */
    public function output(Image $image, OutputInterface $output);

    /**
     * @return string
     */
    public function getName();
}
