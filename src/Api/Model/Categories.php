<?php

namespace Api\Model;

use Core\Model;

class Categories extends Model
{
    public function getList($from = 0, $limit = 1000) //ustawienie domyślnych wartości $from i $limit, żeby nie musieć ich wszędzie wpisywać
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `kategorie` ORDER BY id DESC LIMIT  :from, :limit');
        $stmt->bindParam(':from', $from );
        $stmt->bindParam(':limit', $limit );
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }


    public function save($name, $id = 0)
    {
        if($id !=0) {
            $stmt = $this->pdo->prepare('UPDATE kategorie SET nazwa = :nazwa WHERE id = :id');
            $stmt->bindParam( ':id', $id );

        }else {
            $stmt = $this->pdo->prepare('INSERT INTO kategorie (`nazwa`) VALUES (:nazwa)');
        }

        $stmt->bindParam(':nazwa', $_POST['nazwa']);
        $stmt->execute();
    }

    public function getCategory($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM kategorie WHERE id = :id');
        $stmt->bindParam(':id', $id );
        $stmt->execute();
        $result=$stmt->fetch();

        return $result;
    }

    public function deleteCategory($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM kategorie WHERE id = :id');
        $stmt->bindParam( ':id', $id );
        $stmt->execute();

    }

    public function countCategories()
    {
        return $this->pdo
            ->query('SELECT COUNT(id) as cnt FROM `kategorie`')
            ->fetch()['cnt'];
    }


}