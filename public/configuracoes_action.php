<?php

use Dao\UserDaoMysql;
use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);

$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, "password");
$city = filter_input(INPUT_POST, "city");
$work = filter_input(INPUT_POST, "work");
$passwordConfirm = filter_input(INPUT_POST, "password-confirm");
$birthdate = filter_input(INPUT_POST, "birthdate");




if($email && $name){

    $birthdate = explode("/", $birthdate);
    if(count($birthdate) != 3){
        $_SESSION["flash"] = "Data de nascimento inválida!";
        header("Location: ".$base."/configuracoes");
        exit;
    }

    $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
    if(strtotime($birthdate) === false){
        $_SESSION["flash"] = "Data de nascimento inválida!";
        header("Location: ".$base."/configuracoes");
        exit;
    }

    if($userInfo->getEmail() != $email){
        if($userDao->findByEmail($email) === false){
            $userInfo->setEmail($email);
        }
        else{
            $_SESSION["flash"] = "Email Já Existe";
            header("Location: ".$base."/configuracoes");
            exit;
        }
    }

    $userInfo->setName($name);
    $userInfo->setWork($work);
    $userInfo->setCity($city);
    $userInfo->setBirthdate($birthdate);

    if(!empty($password)){
        if($password === $passwordConfirm){
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $userInfo->setPassword($hash);
        }   
        else{
            $_SESSION["flash"] = "As senhas não batem";
            header("Location: ".$base."/configuracoes");
            exit;
        }
    }

    if(isset($_FILES["avatar"]) && !empty($_FILES["avatar"]["tmp_name"])){
        $newAvatar = $_FILES["avatar"];

        if(in_array($newAvatar["type"], ["image/jpg", "image/jpeg", "image/png"])){
            $avatarWidth = 200;
            $avatarHeight = 200;
            
            list($widthOrig, $heightOrig) = getimagesize($newAvatar["tmp_name"]);
            $ratio = $widthOrig / $heightOrig;
            
            $newWidth = $avatarWidth;
            $newHeight = $newWidth / $ratio;
            
            if ($newHeight < $avatarHeight) {
                $newHeight = $avatarHeight;
                $newWidth = $newHeight * $ratio;
            }
            
            $x = ($avatarWidth - $newWidth) / 2;
            $y = ($avatarHeight - $newHeight) / 2;
            
            $finalImage = imagecreatetruecolor($avatarWidth, $avatarHeight);
            
            switch ($newAvatar["type"]) {
                case "image/jpeg":
                case "image/jpg":
                    $image = imagecreatefromjpeg($newAvatar["tmp_name"]);
                    break;
                case "image/png":
                    $image = imagecreatefrompng($newAvatar["tmp_name"]);
                    break;
            }
            
            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeight, $widthOrig, $heightOrig
            );

            $avatarName = md5(time().rand(0, 9999).'.jpg');
            
            imagejpeg($finalImage, "./media/avatars/".$avatarName, 100);
            $userInfo->setAvatar($avatarName);   
        }
    } 

    if(isset($_FILES["cover"]) && !empty($_FILES["cover"]["tmp_name"])){
        $newcover = $_FILES["cover"];

        if(in_array($newcover["type"], ["image/jpg", "image/jpeg", "image/png"])){
            $coverWidth = 859;
            $coverHeight = 310;
            
            list($widthOrig, $heightOrig) = getimagesize($newcover["tmp_name"]);
            $ratio = $widthOrig / $heightOrig;
            
            $newWidth = $coverWidth;
            $newHeight = $newWidth / $ratio;
            
            if ($newHeight < $coverHeight) {
                $newHeight = $coverHeight;
                $newWidth = $newHeight * $ratio;
            }
            
            $x = ($coverWidth - $newWidth) / 2;
            $y = ($coverHeight - $newHeight) / 2;
            
            $finalImage = imagecreatetruecolor($coverWidth, $coverHeight);
            
            switch ($newcover["type"]) {
                case "image/jpeg":
                case "image/jpg":
                    $image = imagecreatefromjpeg($newcover["tmp_name"]);
                    break;
                case "image/png":
                    $image = imagecreatefrompng($newcover["tmp_name"]);
                    break;
            }
            
            imagecopyresampled(
                $finalImage, $image,
                $x, $y, 0, 0,
                $newWidth, $newHeight, $widthOrig, $heightOrig
            );

            $coverName = md5(time().rand(0, 9999).'.jpg');
            
            imagejpeg($finalImage, "./media/covers/".$coverName, 100);
            $userInfo->setCover($coverName);
        }
        
    } 

    $userDao->update($userInfo);

    
    $_SESSION["flash"] = "dados atualizados com sucesso";
    header("Location: ".$base."/configuracoes");
    exit;

}


$_SESSION["flash"] = "dados não enviados";
header("Location: ".$base."/configuracoes");
exit;
