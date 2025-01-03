<?php

use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$name = filter_input(INPUT_POST, "name");
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, "password");
$birthdate = filter_input(INPUT_POST, "birthdate");


if($email && $password && $name && $birthdate){

    $auth = new Auth($pdo, $base);
    
    $birthdate = explode("/", $birthdate);
    if(count($birthdate) != 3){
        $_SESSION["flash"] = "Data de nascimento inválida!";
        header("Location: ".$base."/cadastro");
        exit;
    }

    $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
    if(strtotime($birthdate) === false){
        $_SESSION["flash"] = "Data de nascimento inválida!";
        header("Location: ".$base."/cadastro");
        exit;
    }

    if($auth->emailExists($email) === false){
        $auth->registerUser($name, $email, $password, $birthdate);
        header("Location: ".$base);
        exit;
    }else{
        $_SESSION["flash"] = "Email já cadastrado!";
        header("Location: ".$base."/cadastro");
        exit;
    }
}


$_SESSION["flash"] = "dados não enviados";
header("Location: ".$base."/cadastro");
exit;
