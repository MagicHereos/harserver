<?php
namespace Erpk\Harserver;

use RuntimeException;
use Erpk\Harvester\Client\Client;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class Bootstrap
{
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function createClient()
    {
        $client = new Client;
        $client->setEmail($this->config->get('email'));
        $client->setPassword($this->config->get('password'));

        if ($this->config->has('userAgent')) {
            $client->setUserAgent($this->config->get('userAgent'));
        }

        return $client;
    }

    public function createRouteCollection()
    {
        $locator = new FileLocator(array(__DIR__));
        $loader = new YamlFileLoader($locator);
        $collection = $loader->load('routing.yml');
        return $collection;
    }
}
