<?php

ini_set('display_errors', '0');
error_reporting(0);

use Dao\PostDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$activeMenu = "home";

$postDao = new PostDaoMysql($pdo);
$getFeed = $postDao->getHomeFeed($userInfo->getId());

$pages = $getFeed["pages"];

include_once "../Partials/header.php";
include_once "../Partials/menu.php";
?>

<section class="feed mt-10">
  <div class="row">
  <div class="column pr-5">
  	  <?php include_once "../Partials/feed-editor.php";?>
      <?php foreach($getFeed["feed"] as $postInfo):?>
      <?php include "../Partials/feed-item.php"?>
      <?php endforeach;?>

      <div class="pagination">
        <?php for($i=0;$i<$pages;$i++):?>
            <a href="<?= $base?>/?p=<?= $i+1?>" class="pagination-item"><?= $i+1?></a>
        <?php endfor;?>
      </div>
      
      </div>
      <div class="column side pl-5">
          <div class="box banners">
              <div class="box-header">
                  <div class="box-header-text">Patrocinios</div>
                  <div class="box-header-buttons">
                      
                  </div>
              </div>
              <div class="box-body">
                  <a href=""><img src="https://alunos.b7web.com.br/media/courses/php.jpg" /></a>
                  <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel.jpg" /></a>
              </div>
          </div>
          <div class="box">
              <div class="box-body m-10">
                  Criado com ❤️
              </div>
          </div>
      </div>
  </div>

</section>


<?php 
  include "../Partials/footer.php"
?>