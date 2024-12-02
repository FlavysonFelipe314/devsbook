<?php

use Dao\PostCommentDaoMysql;
use Models\Auth;
use Models\PostComment;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_POST, "id");
$txt = filter_input(INPUT_POST, "txt");

$array = [];

$postCommentDao = new PostCommentDaoMysql($pdo);

$newComment = new PostComment;
$newComment->id_post = $id;
$newComment->id_user = $userInfo->getId();
$newComment->created_at = date('Y-m-d H:i:s');
$newComment->body = $txt;
$postCommentDao->addComment($newComment);

$array = [
    'error' => '',
    'link' => $base.'/perfil?id='.$userInfo->getId(),
    'avatar' => $base.'/media/avatars/'.$userInfo->getAvatar(),
    'name' => $userInfo->getName(),
    'body' => $txt
];



header("Content-type: application/json");
echo json_encode($array);
exit;