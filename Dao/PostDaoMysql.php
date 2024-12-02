<?php

namespace Dao;

use Models\Post;
use Models\UserDao;
use PDO;
use Dao\PostLikeDaoMysql;
use Models\Auth;


require_once "../vendor/autoload.php";


class PostDaoMysql{
    
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(Post $p)
    {
        $sql = $this->pdo->prepare("INSERT INTO posts (
        id_user, type, created_at, body
        ) VALUES (
         :id_user, :type, :created_at, :body
        )");
        $sql->bindValue(":id_user", $p->getIdUser());
        $sql->bindValue(":type", $p->getType());
        $sql->bindValue(":created_at", $p->getCreatedAt());
        $sql->bindValue(":body", $p->getBody());
        $sql->execute();

        return True;
    }

    public function getHomeFeed($id_user)
    {
        $array = [];
        $perPage = 5;

        $page = intval(filter_input(INPUT_GET, "p"));

        if ($page < 1){
            $page = 1;
        }

        $offset = ($page - 1) * $perPage;

        $urDao = new UserRelationsDaoMysql($this->pdo);
        $userList = $urDao->getRelationsFrom($id_user);
        $userList[] = $id_user;

        $sql = $this->pdo->query("SELECT * FROM posts
        WHERE id_user in (".implode(',', $userList).")
        ORDER BY created_at DESC LIMIT $offset,$perPage");

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array["feed"] = $this->_postListToObject($data, $id_user);
        }


        $pages = $this->pdo->query("SELECT COUNT(*) as c FROM posts
        WHERE id_user in (".implode(',', $userList).")");
        $totalData = $pages->fetch(PDO::FETCH_ASSOC);
        $array["pages"] = ceil($totalData["c"] / $perPage);

        return $array;
    }

    public function getUserFeed($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts
        WHERE id_user = :id_user
        ORDER BY created_at DESC");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }

    public function getUserPhotos($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts
        WHERE id_user = :id_user AND type = 'foto'
        ORDER BY created_at DESC");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }



    private function _postListToObject($post_list, $id_user)
    {
        $posts = [];
        $userDao = new UserDaoMysql($this->pdo);
        $postLikeDao = new PostLikeDaoMysql($this->pdo);
        $postCommentDao = new PostCommentDaoMysql($this->pdo);
        $auth = new Auth($this->pdo, "http://localhost/devsbook/public");
        
        $userInfo = $auth->checkToken();

        foreach($post_list as $post_item){
            $newPost = new Post();
            $newPost->setId($post_item["id"]);
            $newPost->setIdUser($post_item["id_user"]);
            $newPost->setCreatedAt($post_item["created_at"]);
            $newPost->setBody($post_item["body"]);
            $newPost->setType($post_item["type"]);
            $newPost->setMine(false);

            if($post_item["id_user"] == $id_user){
                $newPost->setMine(true);
            }

            $newPost->user = $userDao->findById($post_item["id_user"]);

            $newPost->likeCount = $postLikeDao->getLikeCount($newPost->getId());
            $newPost->liked = $postLikeDao->isLiked($newPost->getId(), $userInfo->getId());

            $newPost->comments = $postCommentDao->getComments($newPost->getId());
            $posts[] = $newPost;
        }

        return $posts;

    }
}