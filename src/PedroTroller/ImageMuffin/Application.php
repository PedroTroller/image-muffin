<?php

namespace PedroTroller\ImageMuffin;

use Symfony\Component\Console\Application as ConsoleApplciation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use PedroTroller\ImageMuffin\Command\MuffinizerCommand;
use Symfony\Component\Console\Helper\HelperSet;

class Application extends ConsoleApplciation
{
    /**
     * {@inheritdoc}
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $input  = null !== $input ? $input : new ArgvInput();
        $output = null !== $output ? $output : new ConsoleOutput();

        $command = new MuffinizerCommand();

        $this->add($command);
        $this->setDefaultCommand($command->getName());

        $this->configureIO($input, $output);

        parent::run($input, $output);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultHelperSet()
    {
        return new HelperSet(array());
    }
}
