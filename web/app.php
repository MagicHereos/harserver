<?php
use Erpk\Harserver\Config;
use Erpk\Harserver\HttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__.'/../vendor/autoload.php';

$config = new Config(__DIR__.'/../config.json');

$request = Request::createFromGlobals();
$httpKernel = new HttpKernel($config);
$response = $httpKernel->handle($request);
$response->send();
