<?php
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Erpk\Harserver\Command\RunCommand;
use Erpk\Harserver\Command\ConfigCommand;

$app = new Application;
$app->defaultConfigPath = realpath(__DIR__.'/../config.json');
$app->add(new RunCommand);
$app->add(new ConfigCommand);
$app->run();
