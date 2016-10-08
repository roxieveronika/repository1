<?php

use Core\Router;
use Symfony\Component\Routing;

$router =  new Router(new Routing\RouteCollection());

$router->addGet('categories', '/categories/{page}', array(
    'page' => 1,
    '_controller' => 'Api\\Controller\\CategoriesController::indexAction'
 //wszystkie metody (edycja itp) maja postfix Action, array wskazuje na konkretna metode, /categories na path
));

$router->addGet('articles', '/articles/{page}', array(
    'page' => 1,
    '_controller' => 'Api\\Controller\\ArticlesController::indexAction'
));

$router->addGet('ind', '/index', array(
    '_controller' => 'Api\\Controller\\CategoriesController::indexAction'
));

$router->addGet('users', '/users/{page}', array(
    'page' => 1,
    '_controller' => 'Api\\Controller\\UsersController::indexAction'
));




$router->addGet('categoryAdd', '/categoryadd', array(

    '_controller' => 'Api\\Controller\\CategoriesController::addAction'
));

$router->addPost('categorySave', '/categorysave/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\CategoriesController::saveAction'
));

$router->addGet('categoryEdit', '/categoryedit/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\CategoriesController::editAction'
));

$router->addGet('categoryDelete', '/categorydelete/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\CategoriesController::deleteAction'
));




$router->addPost('articleSave', '/articlesave/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\ArticlesController::saveAction'
));

$router->addGet('articleEdit', '/articleedit/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\ArticlesController::editAction'
));

$router->addGet('articleAdd', '/articleadd', array(

    '_controller' => 'Api\\Controller\\ArticlesController::addAction' //wszystkie metody oprócz save mają addGet (save ma addPost); articleadd nie może mieć id, bo żadne id nie jest tej operacji przypisane (patrz: articles/index.html.twig
));

$router->addGet('articleDelete', '/articledelete/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\ArticlesController::deleteAction'
));



$router->addGet('userAdd', '/useradd', array(

    '_controller' => 'Api\\Controller\\UsersController::addAction'
));

$router->addGet('userEdit', '/useredit/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\UsersController::editAction'
));

$router->addGet('userDelete', '/userdelete/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\UsersController::deleteAction'
));

$router->addPost('userSave', '/usersave/{id}', array(
    'id' => 0,
    '_controller' => 'Api\\Controller\\UsersController::saveAction'
));



return $router->getRouteCollection();