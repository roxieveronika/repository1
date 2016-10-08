<?php

namespace Api\Controller;
use Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    public function listAction(Request $request)
    {
        return new Response('test');
    }

    public function indexAction($page)
    {
        $categories = $this->pdo('Api\Model\Categories');
        $page--;
        $limit=10;
        $from=$page*$limit;
        $result = $categories->getList($from, $limit);

        $count = $categories->countCategories();

        $allPage = ceil($count / $limit);



        return $this->render('Api/View/index.html.twig', [
            'result' => $result,
            'page'=> $page + 1,
            'allPage'=> $allPage,
        ]);
    }

    public function addAction()
    {
        return $this->render('Api/View/form.html.twig');
    }

    public function saveAction($id, Request $request)
    {

        $categories = $this->pdo('Api\Model\Categories');

        $categories->save($request->get('nazwa'), $id);

        return $this->redirect('/categories');
    }


    public function editAction($id, Request $request) //okreslenie zmiennej id i request - info dla resolver
    {
        $categories = $this->pdo('Api\Model\Categories');
        $result = $categories->getCategory($id);

        return $this->render('Api/View/form.html.twig', [
            'result' => $result
    ]);

    }

    public function deleteAction($id)
    {
        $categories = $this->pdo('Api\Model\Categories');
        $result = $categories->deleteCategory($id);

        return $this->redirect('/categories');

    }

}