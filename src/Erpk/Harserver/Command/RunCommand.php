<?php
namespace Erpk\Harserver\Command;

use React;
use Erpk\Harserver\Config;
use Erpk\Harserver\Bootstrap;
use Erpk\Harserver\HttpKernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;

class RunCommand extends Command
{
    protected $httpKernel;

    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Start server')
            ->addOption(
                'config',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to config file'
            )
            ->addOption(
                'port',
                'p',
                InputOption::VALUE_REQUIRED,
                'Server port',
                1337
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getOption('port');
        $configPath = $input->getOption('config');
        if (!$configPath) {
            $configPath = $this->getApplication()->defaultConfigPath;
        }

        $config = new Config($configPath);
        $this->httpKernel = new HttpKernel($config);

        $loop = React\EventLoop\Factory::create();
        $socket = new React\Socket\Server($loop);
        $http = new React\Http\Server($socket);
        $http->on('request', array($this, 'handleRequest'));
        $socket->listen($port);

        echo 'Server running on http://localhost:'.$port.'/';
        $loop->run();
    }

    public function handleRequest(React\Http\Request $req, React\Http\Response $res)
    {
        $request = Request::create(
            $req->getPath(),
            $req->getMethod(),
            $req->getQuery()
        );

        $response = $this->httpKernel->handle($request);

        $headers = array();
        foreach ($response->headers as $k => $v) {
            $headers[$k] = $v[0];
        }

        $res->writeHead($response->getStatusCode(), $headers);
        $res->end($response->getContent());
    }
}
