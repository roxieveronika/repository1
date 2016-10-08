<?php

namespace Api\Model;

use Core\Model;

class Users extends Model
{
    public function getList($from, $limit)
    {

        $stmt = $this->pdo->prepare('SELECT * FROM `uzytkownicy` ORDER BY id DESC LIMIT  :from, :limit');
        $stmt->bindParam(':from', $from);
        $stmt->bindParam(':limit', $limit);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;

    }

    public function save($name, $id = 0)
    {
        if($id !=0) {
            $stmt = $this->pdo->prepare('UPDATE uzytkownicy SET login = :login, haslo = :haslo WHERE id = :id');
            $stmt->bindParam( ':id', $id );

        }else {
            $stmt = $this->pdo->prepare('INSERT INTO uzytkownicy (`login`, `haslo`) VALUES (:login, :haslo)');
        }

        $stmt->bindParam(':login', $_POST['login']);
        $stmt->bindParam(':haslo', $_POST['haslo']);
        $stmt->execute();
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM uzytkownicy WHERE id = :id');
        $stmt->bindParam(':id', $id );
        $stmt->execute();
        $result=$stmt->fetch();

        return $result;
    }

    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM uzytkownicy WHERE id = :id');
        $stmt->bindParam( ':id', $id );
        $stmt->execute();

    }

    public function countUsers()
    {
        return $this->pdo
            ->query('SELECT COUNT(id) as cnt FROM `uzytkownicy`')
            ->fetch()['cnt'];
    }



}