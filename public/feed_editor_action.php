<?php

use Dao\PostDaoMysql;
use Models\Auth;
use Models\Post;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$body = filter_input(INPUT_GET, "body");
$dateFormated = date("Y-m-d H:i:s");

if($body){
    $postDao = new PostDaoMysql($pdo);

    $newPost = new Post;
    $newPost->setIdUser($userInfo->getId());
    $newPost->settype("text");
    $newPost->setCreatedAt($dateFormated);
    $newPost->setBody($body);

    $postDao->create($newPost);
}

header("Location: ".$base);
exit;
