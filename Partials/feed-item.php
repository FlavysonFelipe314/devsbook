<?php

require_once "feed-item-script.php";

$actionPhrase = "";
switch($postInfo->gettype()):
    case "text":
        $actionPhrase = "Fez uma Postagem";
    break;
    case "foto":
        $actionPhrase = "Postou uma Foto";
    break;
    endswitch;
?>
<div class="box feed-item" data-id="<?= $postInfo->getId(); ?>">
        <div class="box-body">
    <div class="feed-item-head row mt-20 m-width-20">
        <div class="feed-item-head-photo">
        <a href="<?= $base?>/perfil?id=<?= $postInfo->user->getId()?>"><img src="<?= $base?>/media/avatars/<?= $postInfo->user->getAvatar();?>" /></a>
        </div>
        <div class="feed-item-head-info"> 
        <a href="<?= $base?>/perfil?id=<?= $postInfo->user->getId()?>"
            ><span class="fidi-name"><?= $postInfo->user->getName();?></span></a
        >
        <span class="fidi-action"><?= $actionPhrase?></span>
        <br />
        <span class="fidi-date"><?= date('d/m/Y', strtotime($postInfo->getCreatedAt()))?></span>
        </div>
        <div class="feed-item-head-btn">
        <img src="assets/images/more.png" />
        </div>
    </div>
    <div class="feed-item-body mt-10 m-width-20">
    <?= nl2br($postInfo->getBody())?>
    </div>
    <div class="feed-item-buttons row mt-20 m-width-20">
        <div class="like-btn <?= $postInfo->liked ? "on" : "" ?>"><?= $postInfo->likeCount?></div>
        <div class="msg-btn"><?= count($postInfo->comments)?></div>
    </div>
    <div class="feed-item-comments">
        <div class="feed-item-comments-area">
            <?php foreach($postInfo->comments as $comment):?>
                <div class="fic-item row m-height-10 m-width-20">
                    <div class="fic-item-photo">
                      <a href="<?= $base?>/perfil?id=<?= $comment->id_user;?>"><img src="<?= $base?>/media/avatars/<?= $comment->user->getAvatar()?>" /></a>
                    </div>
                    <div class="fic-item-info">
                      <a href="<?= $base?>/perfil?id=<?= $comment->id_user;?>"><?= $comment->user->getName()?></a>
                        <?= $comment->body;?>
                    </div>
                  </div>
            <?php endforeach;?>
        </div>

        <div class="fic-answer row m-height-10 m-width-20">
        <div class="fic-item-photo">
            <a href="<?= $base?>/perfil?id=<?= $userInfo->getId()?>"><img src="<?= $base?>/media/avatars/<?= $userInfo->getAvatar();?>" /></a>
        </div>
        <input
            type="text"
            class="fic-item-field"
            placeholder="Escreva um comentário"
        />
        </div>
    </div>
    </div>
</div>
</form>