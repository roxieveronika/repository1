<?php

namespace Api\Controller;
use Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends Controller
{
    public function listAction(Request $request)
    {
        return new Response('test');
    }

    public function indexAction($page)
    {
        $users = $this->pdo('Api\Model\Users');
        $page--; //odjęcie -1, bo wcześniej było dodane +1
        $limit = 10;
        $from = $page * $limit;
        $result = $users->getList($from, $limit); //$from i $limit muszą tutaj być

        $count = $users->countUsers();

        $allPage = ceil($count / $limit);

        return $this->render('Api/View/Users/index.html.twig', [
            'result' => $result,
            'page' => $page + 1,
            'allPage' => $allPage,
        ]);

    }

    public function addAction()
    {
        return $this->render('Api/View/Users/form.html.twig');
    }

    public function saveAction($id, Request $request)
    {

        $users = $this->pdo('Api\Model\Users');

        $users->save($request->get('login'), $id);
        $users->save($request->get('haslo'), $id);

        return $this->redirect('/users');
    }

    public function editAction($id, Request $request) //okreslenie zmiennej id i request - info dla resolver
    {
        $users = $this->pdo('Api\Model\Users');
        $result = $users->getUser($id);

        return $this->render('Api/View/Users/form.html.twig', [
            'result' => $result
        ]);

    }

    public function deleteAction($id)
    {
        $users = $this->pdo('Api\Model\Users');
        $result = $users->deleteUser($id);

        return $this->redirect('/users');

    }





}