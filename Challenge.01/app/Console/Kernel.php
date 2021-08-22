<?php

namespace App\Console;

use Symfony\Component\Console\Application;
use App\Exceptions\Console\CommandNotFoundException;

class Kernel
{
    /**
     * Symfony Console Application instance.
     *
     * @var \Symfony\Component\Console\Application
     */
    protected Application $app;

    /**
     * The commands provided by console application.
     *
     * @var array
     */
    protected array $commands = [
        \App\Console\Commands\Reports\GenerateUserStatisticsCommand::class,
    ];

    /**
     * Console Kernel constructor.
     *
     * @param \Symfony\Component\Console\Application $app
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register the commands for the console application.
     *
     * @return void
     *
     * @throws \Error
     */
    protected function addConsoleCommands(): void
    {
        if (count($this->commands) !== 0) {
            foreach ($this->commands as $command) {
                $this->app->add(new $command());
            }
        }
    }

    /**
     * Run the console kernel.
     *
     * @return void
     *
     * @throws \App\Exceptions\Command\CommandNotFoundException
     */
    public function handle(): void
    {
        try {
            $this->addConsoleCommands();
        } catch (\Error $error) {
            throw new CommandNotFoundException($error->getMessage());
        }
    }
}
