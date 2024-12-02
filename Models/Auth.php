<?php

namespace Models;

use Dao\UserDaoMysql;
use PDO;

class Auth {
    private $pdo;
    private $base;
    private $dao;

    public function __construct(PDO $driver, $base)
    {
        $this->pdo = $driver;
        $this->base = $base;       
        $this->dao = new UserDaoMysql($this->pdo);
    }

    public function checkToken()
    {
        if(!empty($_SESSION["token"])){
            $token = $_SESSION["token"];
            
            $user = $this->dao->findByToken($token);

            if($user){
                return $user;
                exit;
            }
        }

        header("Location: ".$this->base."/login");
        exit;
    }

    public function validateLogin($email, $password)
    {
        $user = $this->dao->findByEmail($email);

        if($user){

            if(password_verify($password, $user->getPassword())){
                $token = md5(time().rand(0, 9999));

                $_SESSION["token"] = $token;
                $user->setToken($token);
                $this->dao->update($user);
    
                return true;
                exit;
            }

        }
        return false;
        exit;
    }

    public function emailExists($email)
    {

        if($this->dao->findByEmail($email)){
            return true;
            exit;
        }
        return false;

    }

    public function registerUser($name, $email, $password, $birthdate)
    {
        $newUser =  new User;

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $token = md5(time().rand(0,9999));
        $avatar = "default.png";
        $cover = "cover.jpg";

        $newUser->setName($name);
        $newUser->setEmail($email);
        $newUser->setPassword($hash);
        $newUser->setBirthdate($birthdate);
        $newUser->setToken($token);
        $newUser->setAvatar($avatar);
        $newUser->setCover($cover);

        $this->dao->create($newUser);

        $_SESSION["token"] = $token;

    }

    public function logout()
    {
        session_destroy();
        session_unset();
    }

}
