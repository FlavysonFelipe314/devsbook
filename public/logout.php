<?php

use Models\Auth;

require_once "../vendor/autoload.php";
require_once "../Config/Database.php";

$auth = new Auth($pdo, $base);
$auth->logout();

header("Location: ".$base);
exit;

