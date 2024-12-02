<?php

use Dao\UserDaoMysql;
use Dao\UserRelationsDaoMysql;
use Models\Auth;
use Models\UserRelation;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);
$userRelationDao = new UserRelationsDaoMysql($pdo);

$id = filter_input(INPUT_GET, "id");

$userRelation = new UserRelation;
$userRelation->setUserFrom($userInfo->getId());
$userRelation->setUserTo($id);

if(!empty($id)){
    if($userDao->findById($id)){
        if($userRelationDao->isFollowing($userInfo->getId(), $id)){
            $userRelationDao->delete($userRelation);
        }
        else{
            $userRelationDao->create($userRelation);
        }

        $_SESSION["flash"] = "dados não enviados";
        header("Location:".$base.'/perfil?id='.$id);
        exit;

    }
}


$_SESSION["flash"] = "dados não enviados";
header("Location: ".$base);
exit;
