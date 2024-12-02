
<form action="<?= $base?>/feed_editor_action" method="GET"  class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?= $base?>/media/avatars/<?= $avatar?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?= $firstName?></div>
            <textarea name="body" class="feed-new-input" ></textarea>
            <button type="submit" style="border:none;background:transparent;" class="feed-new-send">
                <img src="<?= $base?>/assets/images/send.png" />
            </button>
        </div>
    </div>
</form>
