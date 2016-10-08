<?php

namespace Api\Controller;
use Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{
    public function listAction(Request $request)
    {
        return new Response('test');
    }

    public function indexAction($page)
    {
        $articles = $this->pdo('Api\Model\Articles');
        $page--; //odjęcie -1, bo wcześniej było dodane +1
        $limit=10;
        $from=$page*$limit;
        $result = $articles->getList($from,$limit); //$from i $limit muszą tutaj być

        $count = $articles->countArticles();

        $allPage = ceil($count / $limit);

        return $this->render('Api/View/Articles/index.html.twig', [
            'result' => $result,
            'page'=> $page + 1,
            'allPage'=> $allPage,
        ]);

    }

    public function addAction()
    {
        $categories = $this->pdo('Api\Model\Categories'); //zwraca model kategorii
        $catList = $categories->getList();
        return $this->render('Api/View/Articles/form.html.twig', [
            'catList' => $catList
        ]);
    }

    public function saveAction($id, Request $request)
    {

        $articles = $this->pdo('Api\Model\Articles');
        $data = [
            'tytul' => $request->get('tytul'),
            'data' => $request->get('data'),
            'lead' => $request->get('lead'),
            'tresc' => $request->get('tresc'),
            'idcategory' => $request->get('idcategory'),

        ];
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($request) {
            $tytul = test_input($request->get('tytul'));
            $lead = test_input($request->get('lead'));
            $tresc = test_input($request->get('tresc'));
        }

        $data = [
            'tytul' => $tytul,
            'data' => $request->get('data'),
            'lead' => $lead,
            'tresc' => $tresc,
            'idcategory' => $request->get('idcategory'),
        ];

        if ($data['tytul'] == '' || $data['lead'] == '' || $data['tresc'] == '') {

            $categories = $this->pdo('Api\Model\Categories');
            $catList = $categories->getList();

            return $this->render('Api/View/Articles/form.html.twig',[
                'valid' => 'error',
                'view' => 'articles',
                'result' => $data,
                'idcategory' => $request->get('idcategory'),
                'catList' => $catList
            ]);
        }

        $articles->save ($data, $id);
//        $articles->save($request->get('data'), $id);
//        $articles->save($request->get('lead'), $id);
//        $articles->save($request->get('tresc'), $id);

        $categories = $this->pdo('Api\Model\Categories'); //zwraca model kategorii
        $catList = $categories->getList();

        return $this->redirect('/articles', [
            'catList' => $catList
            ]);
    }

    public function editAction($id, Request $request)
    {
        $articles = $this->pdo('Api\Model\Articles');
        $result = $articles->getArticle($id);

        $categories = $this->pdo('Api\Model\Categories'); //zwraca model kategorii
        $catList = $categories->getList();

        return $this->render('Api/View/Articles/form.html.twig', [
            'catList' => $catList,
            'result' => $result
        ]);

    }

    public function deleteAction($id)
    {
        $articles = $this->pdo('Api\Model\Articles');
        $result = $articles->deleteArticle($id);

        return $this->redirect('/articles');

    }








}