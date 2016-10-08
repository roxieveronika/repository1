<?php

namespace Core;

use Core\Providers\PdoServiceProvider;
use Core\Providers\TwigServiceProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    private $config;
    private $view;
    private $urlGenerator;
    private $pdo;
    private $format;

    public function __construct()
    {
        $this->loadConfig();

        $routes = include __DIR__ . '/../src/routes.php';
        $this->urlGenerator = new UrlGenerator($routes, new Routing\RequestContext());

        $twig = new TwigServiceProvider($this->config['twig']);
        $this->view = $twig->provide(array(
            'urlGenerator' => $this->urlGenerator,
            'getPathInfo' => Request::createFromGlobals()->getPathInfo()
        ));

        $pdo = new PdoServiceProvider($this->config['database']);
        $this->pdo = $pdo->provide();
    }

    private function loadConfig()
    {
        $this->config = include(__DIR__ . '/../src/config.php');
    }

    public function pdo($class)
    {
        return new $class($this->pdo);
    }

    public function render($name, $data = [])
    {
        if($this->format == 'json') {
            $body = json_encode($data);
        } else {
            $body = $this->view->render($name, $data);
        }

        return new Response($body);
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function redirect($path)
    {
        return new RedirectResponse($path);
    }
}