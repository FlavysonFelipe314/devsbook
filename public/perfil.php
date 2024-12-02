<?php

use Dao\PostDaoMysql;
use Dao\UserDaoMysql;
use Dao\UserRelationsDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

// pega informações do usuário
$id = filter_input(INPUT_GET, "id");
if(!$id){
    $id = $userInfo->getId();
}

$activeMenu = "perfil";

if($id != $userInfo->getId()){
    $activeMenu = "";
}

$userDao = new UserDaoMysql($pdo);

$user = $userDao->findById($id, true);

if(!$user){
    header("Location:".$base);
    exit;
}

$dateFrom = new DateTime($user->getBirthdate());
$dateTo = new DateTime("today");
$ageYears = $dateFrom->diff($dateTo)->y;

// Procura o feed do usuario
$postDao = new PostDaoMysql($pdo);
$getFeed = $postDao->getUserFeed($user->getId());


$userRelationDao = new UserRelationsDaoMysql($pdo);

$isFollowing = $userRelationDao->isFollowing($userInfo->getId(), $id);

include_once "../Partials/header.php";
include_once "../Partials/menu.php";
?>

<section class="feed">

    <div class="row">
        <div class="box flex-1 border-top-flat">
            <div class="box-body">
                <div class="profile-cover" style="background-image: url('<?= $base?>/media/covers/<?= $user->getCover()?>');"></div>
                <div class="profile-info m-20 row">
                    <div class="profile-info-avatar">
                        <img src="<?= $base?>/media/avatars/<?= $user->getAvatar()?>" />
                    </div>
                    <div class="profile-info-name">
                        <div class="profile-info-name-text"><?= $user->getName();?></div>
                        <?php if(!empty($user->getCity())):?>
                            <div class="profile-info-location"><?= $user->getCity()?></div>
                        <?php endif;?>
                        </div>
                    <div class="profile-info-data row">
                        <?php if($id != $userInfo->getId()):?>
                            <div class="profile-info-item m-width-20">
                                <a href="<?= $base?>/follow_action?id=<?= $id?>"><button class="button"><?= (!$isFollowing) ? "Seguir" : "Deixar de Seguir"?></button></a>
                            </div>
                        <?php endif;?>

                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($user->followers)?></div>
                            <div class="profile-info-item-s">Seguidores</div>
                        </div>
                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($user->following)?></div>
                            <div class="profile-info-item-s">Seguindo</div>
                        </div>
                        <div class="profile-info-item m-width-20">
                            <div class="profile-info-item-n"><?= count($user->fotos)?></div>
                            <div class="profile-info-item-s">Fotos</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">

        <div class="column side pr-5">
            
            <div class="box">
                <div class="box-body">
                    
                    <div class="user-info-mini">
                        <img src="assets/images/calendar.png" />
                        <?= date("d/m/Y", strtotime($user->getBirthdate()))?> (<?= $ageYears?> anos)
                    </div>
                    
                    <?php if(!empty($user->getCity())):?>
                    <div class="user-info-mini">
                        <img src="<?= $base?>/assets/images/pin.png" />
                        <?= $user->getCity()?>
                    </div>
                    <?php endif;?>

                    <?php if(!empty($user->getWork())):?>
                    <div class="user-info-mini">
                        <img src="<?= $base?>/assets/images/work.png" />
                        <?= $user->getWork()?>
                    </div>
                    <?php endif;?>

                </div>
            </div>

            <div class="box">
                <div class="box-header m-10">
                    <div class="box-header-text">
                        Seguindo
                        <span>(<?= count($user->following)?>)</span>
                    </div>
                    <div class="box-header-buttons">
                        <a href="<?= $base?>/amigos?id=<?= $user->getId()?>">ver todos</a>
                    </div>
                </div>
                <div class="box-body friend-list">
                    <?php if(count($user->following) > 0):?>
                        <?php foreach($user->following as $item):?>
                            <div class="friend-icon">
                                <a href="<?= $base?>/perfil?id=<?= $item->getId()?>">
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

        </div>
        <div class="column pl-5">

            <div class="box">
                <div class="box-header m-10">
                    <div class="box-header-text">
                        Fotos
                        <span>(<?= count($user->fotos)?>)</span>
                    </div>
                    <div class="box-header-buttons">
                        <a href="<?= $base?>/fotos?id=<?= $user->getId()?>">ver todos</a>
                    </div>
                </div>
                <div class="box-body row m-20">
                    <?php if(count($user->fotos) > 0):?>
                        <?php foreach($user->fotos as $item):?>
                            <div class="user-photo-item">
                                <a href="#modal-1" rel="modal:open">
                                    <img src="<?= $base?>/media/uploads/<?= $item->getBody()?>" />
                                </a>
                                <div id="modal-1" style="display:none">
                                    <img src="<?= $base?>/media/uploads/<?= $item->getBody()?>" />
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>

          
            <?php
                if($id == $userInfo->getId()){
                    include "../Partials/feed-editor.php";
                }            

                if(!empty($getFeed)){
                    foreach($getFeed as $postInfo){
                        include "../Partials/feed-item.php";
                    }
                }else{
                    echo "não há postagens desse usuário";
                }
            ?>
            

        </div>
    </div>
</section>
<?php 
  include "../Partials/footer.php"
?>