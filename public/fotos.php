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

$activeMenu = "fotos";

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

            <div class="full-user-photos">

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
                <?php else:?>
                    <h1>usuário não possui fotos</h1>
            <?php endif;?>

            </div>
            

        </div>
    </div>

</div>

</div>

</section>
<?php 
include "../Partials/footer.php"
?>