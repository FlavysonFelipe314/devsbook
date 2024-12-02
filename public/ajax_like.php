<?php

use Dao\PostLikeDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, "id");

if(!empty($id)){
    $postLikeDao = new PostLikeDaoMysql($pdo);

    $postLikeDao->likeToogle($id, $userInfo->getId());
}