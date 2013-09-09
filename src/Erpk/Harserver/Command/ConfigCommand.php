<?php
namespace Erpk\Harserver\Command;

use Erpk\Harserver\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigCommand extends Command
{
    protected $client;
    protected $routes;

    protected function configure()
    {
        $this
            ->setName('config')
            ->setDescription('Create configuration file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $config = new Config($this->getApplication()->defaultConfigPath);

        $config->set(
            'email',
            $dialog->ask(
                $output,
                'Your eRepublik e-mail address: '
            )
        );

        $config->set(
            'password',
            $dialog->ask(
                $output,
                'Your eRepublik password: '
            )
        );

        $config->set(
            'userAgent',
            $dialog->ask(
                $output,
                'User-Agent string (leave empty for default): ',
                null
            )
        );

        $config->save();
        $output->writeln('Configuration file has been written to '.$config->getPath());
        $output->writeln('You can use harserver now!');
    }
}
