<?php

namespace Api\Model;

use Core\Model;

class Articles extends Model
{
    public function getList($from, $limit)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM `wpisy` ORDER BY id DESC LIMIT  :from, :limit');
        $stmt->bindParam(':from', $from );
        $stmt->bindParam(':limit', $limit );
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;

    }

    public function save($data, $id = 0)
    {
        if($id !=0) {
            $stmt = $this->pdo->prepare('UPDATE wpisy SET tytul = :tytul, data = :data, lead = :lead, tresc = :tresc, idcategory = :idcategory WHERE id = :id');
            $stmt->bindParam( ':id', $id );

        } else {
            $stmt = $this->pdo->prepare('INSERT INTO wpisy (`tytul`, `data`, `lead`, `tresc`, `idcategory`) VALUES (:tytul, :data, :lead, :tresc, :idcategory)');
        }

        $stmt->bindParam(':tytul', $data['tytul']);
        $stmt->bindParam(':data', $data['data']);
        $stmt->bindParam(':lead', $data['lead']);
        $stmt->bindParam(':tresc', $data['tresc']);
        $stmt->bindParam(':idcategory', $data['idcategory']);
        $stmt->execute();
    }

    public function getArticle($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM wpisy WHERE id = :id');
        $stmt->bindParam(':id', $id );
        $stmt->execute();
        $result=$stmt->fetch();

        return $result;
    }

    public function deleteArticle($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM wpisy WHERE id = :id');
        $stmt->bindParam( ':id', $id );
        $stmt->execute();

    }

    public function countArticles()
    {
        return $this->pdo
            ->query('SELECT COUNT(id) as cnt FROM `wpisy`')
            ->fetch()['cnt'];
    }
}