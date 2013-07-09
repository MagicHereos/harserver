<?php
use API\Renderer;
use API\ViewModel;
use Symfony\Component\Routing\Router;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Erpk\Harvester\Client\Client;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Erpk\Harvester\Exception\Exception as ErpkException;

require __DIR__.'/../../vendor/autoload.php';

$locator = new FileLocator(array(__DIR__));
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

$router = new Router(
    new YamlFileLoader($locator),
    __DIR__.'/../../src/API/routing.yml',
    array('cache_dir' => __DIR__.'/../cache'),
    $context
);

$controller = function ($params) {
    $configPath = __DIR__.'/../config.json';

    if (!file_exists($configPath)) {
        return ViewModel::error('Configuration file is missing', 500);
    }

    $config = json_decode(file_get_contents($configPath));

    if ($config === null) {
        return ViewModel::error('Configuration file is invalid', 500);
    }

    $client = new Client;
    $client->setEmail($config->email);
    $client->setPassword($config->password);

    $ex = explode('::', $params['_controller']);
    $className = 'API\Controller\\'.$ex[0];

    $obj = new $className($client, $params);
    try {
        return $obj->{$ex[1]}();
    } catch (ErpkException $e) {
        return ViewModel::error(get_class($e), 500);
    }
};

try {
    $parameters = $router->match($request->getPathinfo());
    $vm = $controller($parameters);
} catch (ResourceNotFoundException $e) {
    $vm = ViewModel::error('NotFoundException', 404);
}

if (isset($parameters['_format'])) {
    switch ($parameters['_format']) {
        case 'xml':
            $renderer = new Renderer\XML;
            break;
        case 'json':
        default:
            $renderer = new Renderer\JSON;
    }
} else {
    $renderer = new Renderer\JSON;
}

$response = new Response();
$response->setStatusCode($vm->getStatusCode());
$renderer->render($response, $vm);

$headers = array();
foreach ($response->headers as $k => $v) {
    $headers[$k] = $v[0];
}

$response->send();
