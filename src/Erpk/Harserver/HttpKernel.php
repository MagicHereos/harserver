<?php
namespace Erpk\Harserver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Erpk\Harvester\Exception\Exception as ErpkException;
use Erpk\Harserver\Renderer;
use Erpk\Harserver\ViewModel;

class HttpKernel
{
    protected $client;
    protected $routes;

    public function __construct(Config $config)
    {
        $bootstrap = new Bootstrap($config);
        $this->client = $bootstrap->createClient();
        $this->routes = $bootstrap->createRouteCollection();
    }

    protected function controller($params)
    {
        $ex = explode('::', $params['_controller']);
        $className = 'Erpk\Harserver\Controller\\'.$ex[0];

        $obj = new $className($this->client, $params);
        try {
            return $obj->{$ex[1]}();
        } catch (ErpkException $e) {
            return ViewModel::error(get_class($e), 500);
        }
    }

    public function handle(Request $request)
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);

        try {
            $parameters = $matcher->match($request->getPathInfo());
            $vm = $this->controller($parameters);
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

        return $response;
    }
}
