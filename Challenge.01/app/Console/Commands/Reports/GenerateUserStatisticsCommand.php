<?php

namespace App\Console\Commands\Reports;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUserStatisticsCommand extends Command
{
    /**
     * The default command name.
     *
     * @var string
     */
    protected static $defaultName = 'generate:users-stats';

    /**
     * Define a description, help message and the input options and arguments.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->addOption(
                'start-date',
                null,
                InputOption::VALUE_REQUIRED,
                'The start date for report'
            )
            ->addOption(
                'end-date',
                null,
                InputOption::VALUE_REQUIRED,
                'End period'
            )
            ->setDescription('Generate statistics of users\' entitlements');
    }

    /**
     * Handle installing the development environment from scratch.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $startDate = $input->getOption('start-date');
        $endDate   = $input->getOption('end-date');

        // Your code ..

        return (int) true;
    }
}
