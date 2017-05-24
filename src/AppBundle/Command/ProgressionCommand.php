<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of ProgressionCommand
 *
 * @author olidera.ndrianala
 */
class ProgressionCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('demo:progress')
            ->setDescription('Demo Progress Bar')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // create a new progress bar (50 units)
        $progress = new \Symfony\Component\Console\Helper\ProgressBar($output, 50);

        // start and displays the progress bar
        $progress->start();
        $i = 0;

        while ($i++ < 50) {
            // ... do some work
            // advance the progress bar 1 unit
            $progress->advance();

            // you can also advance the progress bar by more than 1 unit
            // $progress->advance(3);
        }

        // ensure that the progress bar is at 100%
        $progress->finish();
    }

}
