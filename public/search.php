<?php

use Dao\PostDaoMysql;
use Dao\UserDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$activeMenu = "search";

$userDao = new UserDaoMysql($pdo);

$query = filter_input(INPUT_GET, "s");
if(empty($query)){
    header("Location: ".$base);
}

$results = $userDao->findByName($query);

include_once "../Partials/header.php";
include_once "../Partials/menu.php";
?>
<section class="feed mt-10">
  <div class="row">
  <div class="column pr-5">

        <h1>Pesquisa por: <?= $query?></h1>
        <h3 style="font-size: 12px; color:#666;"><?= count($results)?> Resultados Encontrados</h3>
        <div class="content" style="display:flex;justify-content:left;">
            <?php if(count($results) > 0):?>
                <?php foreach($results as $item):?>
                    <div class="friend-icon"style="margin: 10px;">
                        <a href="<?= $base?>/perfil?id=<?= $item->getId()?>" >
                            <div class="friend-icon-avatar">
                                <img src="<?= $base?>/media/avatars/<?= $item->getAvatar()?>" />
                            </div>
                            <div class="friend-icon-name">
                                <?= $item->getName()?>
                            </div>
                        </a>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
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
                  <a href=""><img src="https://alunos.b7web.com.br/media/courses/php-nivel-1.jpg" /></a>
                  <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel-nivel-1.jpg" /></a>
              </div>
          </div>
          <div class="box">
              <div class="box-body m-10">
                  Criado com ❤️ por B7Web
              </div>
          </div>
      </div>
  </div>

</section>


<?php 
  include "../Partials/footer.php"
?>