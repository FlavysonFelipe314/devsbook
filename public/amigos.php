<?php

use Dao\PostDaoMysql;
use Dao\UserDaoMysql;
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

$activeMenu = "amigos";

if($id != $userInfo->getId()){
    $activeMenu = "";
}

$userDao = new UserDaoMysql($pdo);

$user = $userDao->findById($id, true);

if(!$user){
    header("Location:".$base);
    exit;
}

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

<div class="column">
    
    <div class="box">
        <div class="box-body">

            <div class="tabs">
                <div class="tab-item" data-for="followers">
                    Seguidores
                </div>
                <div class="tab-item active" data-for="following">
                    Seguindo
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-body" data-item="followers">
                    
                    <div class="full-friend-list">
                    <?php if(count($user->followers) > 0):?>
                        <?php foreach($user->followers as $item):?>
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
                <div class="tab-body" data-item="following">
                    
                    <div class="full-friend-list">
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

        </div>
    </div>

</div>

</div>
</section>
<?php 
include "../Partials/footer.php"
?>