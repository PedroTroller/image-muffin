<?php

namespace PedroTroller\ImageMuffin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Faker\Factory as FakerFactory;
use PedroTroller\ImageMuffin\Selector;
use Faker\Provider\Base as Faker;
use PedroTroller\ImageMuffin\Image;
use Imagine\Filter\Transformation;
use Imagine\Image\Box;
use Imagine\Imagick\Imagine;
use PedroTroller\ImageMuffin\Formatter\Filename;
use Imagine\Image\ImageInterface;

class MuffinizerCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $defaultFolder = sprintf('%s/fixtures', dirname(dirname(dirname(dirname(__DIR__)))));
        $extensions = implode(', ', $this->getAvailableExtensions());

        $this
            ->setName('muffinize')
            ->setDescription('Generate an image')
            ->addOption('width', 'W', InputOption::VALUE_OPTIONAL, 'Image width')
            ->addOption('height', 'H', InputOption::VALUE_OPTIONAL, 'Image height')
            ->addOption('samples', 'S', InputOption::VALUE_OPTIONAL, 'Image samples folder', $defaultFolder)
            ->addOption('extension', 'E', InputOption::VALUE_OPTIONAL, sprintf('Image extension [%s]', $extensions))
            ->addOption('formatter', 'f', InputOption::VALUE_OPTIONAL, 'Output format', 'filename')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $imagine = new Imagine();

        $width = $input->getOption('width') ?: Faker::numberBetween(200, 1200);
        $height = $input->getOption('height') ?: Faker::numberBetween(200, 1200);
        $extension = $input->getOption('extension') ?: Faker::randomElement($this->getAvailableExtensions());

        $selector = new Selector($input->getOption('samples'));

        $images = $selector->select($width, $height, $extension);
        $filter = array_filter($images, function (Image $image) use ($width, $height) {
            return ($width * $height) >= $image->getPixels();
        });

        if (true === empty($filter)) {
            $image = Faker::randomElement($images);
        } else {
            $image = Faker::randomElement($filter);
        }

        $transformed = tempnam(sys_get_temp_dir(), uniqid());

        $transformation = new Transformation();
        $transformation
            ->thumbnail(new Box($width, $height), ImageInterface::THUMBNAIL_OUTBOUND)
            ->save($transformed)
        ;

        $transformation->apply($imagine->open($image->getPath()));

        $this->getFormatter($input->getOption('formatter'))->output(new Image($transformed), $output);
    }

    /**
     * @return string[]
     */
    private function getAvailableExtensions()
    {
        return [
            Selector::EXT_JPG,
        ];
    }

    /**
     * @param string $name
     *
     * @return Formatter
     */
    private function getFormatter($name)
    {
        $formatters = [
            new Filename,
        ];

        foreach ($formatters as $formatter) {
            if ($name === $formatter->getName()) {
                return $formatter;
            }
        }

        throw new \Exception('Formatter unknown');
    }
}
