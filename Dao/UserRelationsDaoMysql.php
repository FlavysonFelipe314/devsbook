<?php

namespace Dao;

use Models\UserRelation;
use PDO;

require_once "../vendor/autoload.php";

class UserRelationsDaoMysql{
    
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(UserRelation $u)
    {
        $sql = $this->pdo->prepare("INSERT INTO userrelations 
        (user_from, user_to) VALUES (:user_from, :user_to)");
        $sql->bindValue(":user_from", $u->getUserFrom());
        $sql->bindValue(":user_to", $u->getUserTo());
        $sql->execute();
    }

    
    public function delete(UserRelation $u)
    {
        $sql = $this->pdo->prepare("DELETE FROM userrelations WHERE user_from = :user_from AND  user_to = :user_to");
        $sql->bindValue(":user_from", $u->getUserFrom());
        $sql->bindValue(":user_to", $u->getUserTo());
        $sql->execute();
    }

    public function getRelationsFrom($id)
    {
        $users = [];
        $sql = $this->pdo->prepare("SELECT user_to FROM userrelations WHERE user_from = :user_from");
        $sql->bindValue(":user_from", $id);
        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $item){
            $users[] = $item["user_to"];
        }

        return $users;
    }

    public function getRelationsTo($id)
    {
        $users = [];
        $sql = $this->pdo->prepare("SELECT user_from FROM userrelations WHERE user_to = :user_to");
        $sql->bindValue(":user_to", $id);
        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $item){
            $users[] = $item["user_from"];
        }

        return $users;
    }

    public function isFollowing($id1, $id2)
    {
        $sql = $this->pdo->prepare("SELECT * FROM userrelations WHERE user_from = :user_from AND user_to = :user_to");
        $sql->bindValue(":user_from", $id1);
        $sql->bindValue(":user_to", $id2);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}