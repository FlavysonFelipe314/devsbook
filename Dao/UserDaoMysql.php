<?php

namespace Dao;

use Models\User;
use Models\UserDao;
use PDO;

require_once "../vendor/autoload.php";

class UserDaoMysql implements UserDao {
    
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function generateUser($array, $full = false)
    {
        $user = new User;
        $user->setId($array["id"]);
        $user->setName($array["name"]);
        $user->setEmail($array["email"]);
        $user->setPassword($array["password"]);
        $user->setToken($array["token"]);
        $user->setBirthdate($array["birthdate"]);
        $user->setAvatar($array["avatar"]);
        $user->setCover($array["cover"]);
        $user->setCity($array["city"]);
        $user->setWork($array["work"]);

        if($full){

            $urDaoMysql = new UserRelationsDaoMysql($this->pdo);
            $postDao = new PostDaoMysql($this->pdo);
            
            $user->following = $urDaoMysql->getRelationsFrom($user->getId());
            foreach($user->following as $key => $following_id){
                $newUser = $this->findById($following_id);
                $user->following[$key] = $newUser;
            }
            $user->followers = $urDaoMysql->getRelationsTo($user->getId());
            foreach($user->followers as $key => $followers_id){
                $newUser = $this->findById($followers_id);
                $user->followers[$key] = $newUser;
            }

            $user->fotos = $postDao->getUserPhotos($user->getId());

        }

        return $user;
    }

    public function create(User $u)
    {
        $sql = $this->pdo->prepare("INSERT INTO users 
        (email, password, name, birthdate, token, avatar, cover
        ) VALUES (
        :email, :password, :name, :birthdate, :token, :avatar, :cover
        )");

        $sql->bindValue(":email", $u->getEmail());
        $sql->bindValue(":password", $u->getPassword());
        $sql->bindValue(":name", $u->getName());
        $sql->bindValue(":birthdate", $u->getBirthdate());
        $sql->bindValue(":token", $u->getToken());
        $sql->bindValue(":avatar", $u->getAvatar());
        $sql->bindValue(":cover", $u->getCover());
        $sql->execute();
    }
    
    public function update(User $u)
    {

        $sql = $this->pdo->prepare("UPDATE users SET
        email = :email,
        password = :password,
        name = :name,
        birthdate = :birthdate,
        city = :city,
        work = :work,
        avatar = :avatar,
        cover = :cover,
        token =:token
        WHERE id = :id");

        $sql->bindValue(":email", $u->getEmail());
        $sql->bindValue(":password", $u->getPassword());
        $sql->bindValue(":name", $u->getName());
        $sql->bindValue(":birthdate", $u->getBirthdate());
        $sql->bindValue(":city", $u->getCity());
        $sql->bindValue(":work", $u->getWork());
        $sql->bindValue(":avatar", $u->getAvatar());
        $sql->bindValue(":cover", $u->getCover());
        $sql->bindValue(":token", $u->getToken());
        $sql->bindValue(":id", $u->getId());
        $sql->execute();

        return True;
    }

    public function delete($id){}

    public function findById($id, $full = false)
    {
        if(!empty($id)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data, $full);
                return $user;
                exit;
            }
        }
        return false;
    }

    public function findByName($name)
    {   
        $array = [];

        if(!empty($name)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE name LIKE :name");
            $sql->bindValue(":name", "%".$name."%");
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);

                foreach($data as $item){
                    $array[] = $this->generateUser($item);
                }
            }
        }
        return $array;
    }

    public function findByEmail($email)
    {
        if(!empty($email)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $sql->bindValue(":email", $email);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);
                return $user;
                exit;
            }
        }
        return false;
    }

    public function findByToken($token)
    {
        if(!empty($token)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
            $sql->bindValue(":token", $token);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);
                return $user;
                exit;
            }
        }
        return false;
    }

    public function findAll(){}
}