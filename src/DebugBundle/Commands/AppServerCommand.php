<?php

namespace App\DebugBundle\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * An nut command for basic PHP server.
 */
class AppServerCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:server')
            ->setDescription('Launch php server')
            ->addOption(
                'port',
                'p',
                InputOption::VALUE_OPTIONAL,
                'Port',
                8000
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption('port');

        $output->writeln(sprintf('Launching server on port %d', (int)$port));

        exec(sprintf('php -S localhost:%d -t public public/index.php', (int)$port));
    }
}
