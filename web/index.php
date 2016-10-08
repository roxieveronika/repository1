<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/routes.php';


$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context); //urlmatcher dostaje info o ruterach i requestach

$controllerResolver = new ControllerResolver(); //na podst requestu dopasuje request do konkretnego controllera
$argumentResolver = new ArgumentResolver();

$framework = new Core\Framework($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();