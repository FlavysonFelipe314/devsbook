<?php

use Dao\PostDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$activeMenu = "configuracoes";

include_once "../Partials/header.php";
include_once "../Partials/menu.php";
?>

<section class="feed mt-10">
  <div class="row">

    <form action="configuracoes_action" method="POST" class="form-config" enctype="multipart/form-data">
    <?php if(!empty($_SESSION["flash"])):?>
        <?= $_SESSION["flash"]?>
        <?php $_SESSION["flash"] = ""?>
    <?php endif;?>
    <br>
    <img class="avatar" src="<?= $base?>/media/avatars/<?=$userInfo->getAvatar()?>" alt="">
    <label for="">
          <input type="file" name="avatar" >
      </label>
      <br>
      <img class="cover" src="<?= $base?>/media/covers/<?=$userInfo->getCover()?>" alt="">
      <label for="">
          <input type="file" name="cover" >
      </label>
      <br>
      <label for="">
          Nome
          <input type="text" name="name" value="<?=$userInfo->getName()?>">
      </label>
      <br>
      <label for="">
          Email
          <input type="email" name="email" value="<?=$userInfo->getEmail()?>">
      </label>
      <br>
      <label for="">
          Birthdate
          <input type="text" name="birthdate" id="birthdate" value="<?=date('d/m/Y', strtotime($userInfo->getBirthdate()))?>">
      </label>
      <br>
      <label for="">
          Work
          <input type="text" name="work" value="<?=$userInfo->getWork()?>">
      </label>
      <br>
      <label for="">
          City
          <input type="text" name="city" value="<?=$userInfo->getCity()?>">
      </label>
      <br>
      <label for="">
          Password
          <input type="password" name="password" >
      </label>
      <br>
      <label for="">
          Confirm Password
          <input type="password" name="password-confirm" >
      </label>
      
      <button class="btn" type="submit">Enviar</button>
    </form>

  </div>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("birthdate"),
        {mask:'00/00/0000'}
    )
</script>
<?php 
  include "../Partials/footer.php"
?>