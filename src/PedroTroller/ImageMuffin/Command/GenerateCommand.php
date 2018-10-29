<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin\Command;

use Exception;
use PedroTroller\ImageMuffin\Formats;
use PedroTroller\ImageMuffin\Generator;
use PedroTroller\ImageMuffin\Images;
use PedroTroller\ImageMuffin\Manipulations;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateCommand extends Command
{
    private const DEFAULT_FORMAT    = 'jpg';
    private const DEFAULT_GENERATOR = 'content';

    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Generate an image')
            ->addOption('landscape', null, InputOption::VALUE_NONE, 'Will generate a landscape.')
            ->addOption('portrait', null, InputOption::VALUE_NONE, 'Will generate a portrait.')
            ->addOption('width', null, InputOption::VALUE_OPTIONAL, 'The desired width of the image.')
            ->addOption('height', null, InputOption::VALUE_OPTIONAL, 'The desired height of the image.')
        ;

        foreach (Formats::all() as $format) {
            $this->addOption(
                $format,
                null,
                InputOption::VALUE_NONE,
                sprintf('Will generate a .%s image%s.', $format, self::DEFAULT_FORMAT === $format ? ' (default)' : '')
            );
        }

        foreach ($this->getGenerators() as $name => $generator) {
            $this->addOption(
                $name,
                null,
                InputOption::VALUE_NONE,
                sprintf('Will return the %s of the resulting image%s.', $name, self::DEFAULT_GENERATOR === $name ? ' (default)' : '')
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $format        = $this->extractFormat($input);
        $generator     = $this->extractGenerator($input);
        $manipulations = $this->extractManipulations($input);
        $orientation   = $this->detectOrientation($input);

        $images = new Images();

        if (null !== $orientation) {
            $images = $images->$orientation();
        }

        $images = iterator_to_array($images);

        shuffle($images);

        $output->writeln(
            $generator->generate(current($images), $manipulations, $format)
        );
    }

    /**
     * @return Generator\Base64[] | Generator\Content[]
     */
    private function getGenerators(): array
    {
        $content = new Generator\Content();

        return [
            self::DEFAULT_GENERATOR => $content,
            'base64'                => new Generator\Base64($content),
        ];
    }

    private function extractFormat(InputInterface $input): string
    {
        $selected = null;

        foreach (Formats::all() as $format) {
            if (false === $input->getOption($format)) {
                continue;
            }

            if (null !== $selected) {
                throw new Exception(sprintf('You can\'t use both --%s and --%s options.', $selected, $format));
            }

            $selected = $format;
        }

        return $selected ?: self::DEFAULT_FORMAT;
    }

    /**
     * @return Generator\Base64 | Generator\Content
     */
    private function extractGenerator(InputInterface $input)
    {
        $selected = null;

        foreach ($this->getGenerators() as $name => $generator) {
            if (false === $input->getOption($name)) {
                continue;
            }

            if (null !== $selected) {
                throw new Exception(sprintf('You can\'t use both --%s and --%s options.', $selected, $name));
            }

            $selected = $name;
        }

        return $this->getGenerators()[$selected ?: self::DEFAULT_GENERATOR];
    }

    private function extractManipulations(InputInterface $input): Manipulations
    {
        $size = [
            $input->getOption('width'),
            $input->getOption('height'),
        ];

        foreach ($size as $index => $value) {
            if (is_numeric($value)) {
                $size[$index] = (int) $value;
            }
        }

        return new Manipulations(...$size);
    }

    private function detectOrientation(InputInterface $input): ? string
    {
        $width  = $input->getOption('width');
        $height = $input->getOption('height');

        $landscape = $input->getOption('landscape');
        $portrait  = $input->getOption('portrait');

        if (($landscape || $portrait) && $width && $height) {
            throw new Exception('You can\'t use --landscape or --portrait with both --with and --height.');
        }

        if ($landscape) {
            return 'landscape';
        }

        if ($portrait) {
            return 'portrait';
        }

        if (null !== $width && null !== $height) {
            if ((int) $width === (int) $height) {
                return null;
            }

            return (int) $width > (int) $height
                ? 'landscape'
                : 'portrait'
            ;
        }

        return null;
    }
}
