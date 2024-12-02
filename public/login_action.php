<?php

use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password");

    if($email && $password){
        $auth = new Auth($pdo, $base);
        if($auth->validateLogin($email, $password)){
            
            header("Location: ".$base);
            exit;
        }
    }

}

$_SESSION["flash"] = "Email e/ou senha Incorretos!";
header("Location: ".$base."/login");
exit;

