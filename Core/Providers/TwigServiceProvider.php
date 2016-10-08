<?php

namespace Core\Providers;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

class TwigServiceProvider extends ServiceProvider
{
    public function provide(array $options = [])
    {
        $loader = new Twig_Loader_Filesystem($this->config['dir']);
        $twig = new Twig_Environment($loader, array(
            'cache' => $this->config['cache'],
            'auto_reload' => true
        ));


        if(!isset($options['urlGenerator']) || false == $options['urlGenerator'] instanceof UrlGenerator) {
            throw new \Exception('twig provide must have urlGenerator');
        }

        $functionUrlGenerator = new Twig_SimpleFunction('url', function($name, $parameters = []) use ($options) {
            return $options['urlGenerator']->generate($name, $parameters);
        });



        $functionGetPathInfo = new Twig_SimpleFunction('getPathInfo', function() use ($options) {
            return $options['getPathInfo'];
        });

        $functionPagination = new Twig_SimpleFunction('pagination', function($page, $allPage, $path) use ($options) {
            $start = $page - 2;
            if($start<1) {
                $start = 1;
            }

            $finish = $start + 4;
            if($finish > $allPage) {
                $dif = $finish - $allPage;
                $finish = $allPage;
                $start = $start - $dif;
            }

            echo '<ul class="pagination" method="get">';

            for($i=$start; $i <= $finish; $i++) {
                $url = $options['urlGenerator']->generate($path, ['page'=>$i]);
                if($i == $page) {
                    echo '<li class="active"><a href="'.$url.'">'.$page.'</a></li>';
                } else {
                    echo '<li><a href="'.$url.'">'.$i.'</a></li>';
                }
//
            }
            echo '</ul>';
        });


        $twig->addFunction($functionUrlGenerator);
        $twig->addFunction($functionGetPathInfo);
        $twig->addFunction($functionPagination);

        return $twig;
    }
}