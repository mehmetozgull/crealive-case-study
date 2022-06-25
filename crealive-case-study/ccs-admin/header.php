<?php
ob_start(); session_start();
require_once "../classes/allClass.php";
require_once "../functions/functions.php";
$db = new ccs\db\Database();
$security = new ccs\security\Security();
$session = new ccs\security\Session();
$token = new ccs\security\Token();
$siteUrl = $db->settings("url");
$path_parts = pathinfo($_SERVER["PHP_SELF"]);
$fileName = $path_parts["filename"];
if ($fileName == "header") {
    header("Location:" . $siteUrl . "/ccs-admin");
}
?>
<!doctype html>
<html lang="tr-TR">
<head>
    <meta http-equiv="Content-Type" content="text/html charset=utf-8">
    <meta http-equiv="Content-Language" content="tr">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta charset="utf-8">
    <title><?= $db->settings("title"); ?> Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <header>
    <!-- Intro settings -->
    <style>
        #intro {
            /* Margin to fix overlapping fixed navbar */
            margin-top: 58px;
        }
        @media (max-width: 991px) {
            #intro {
                /* Margin to fix overlapping fixed navbar */
                margin-top: 45px;
            }
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $siteUrl; ?>/ccs-admin/" style="margin-top: -3px;">
                Crealive Blog Case Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
                    aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarExample01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <ul class="navbar-nav d-flex flex-row">
                    <li class="nav-item me-3 me-lg-0">
                        <a class="btn btn-outline-primary my-btn" email="<?= $db->settings("email") ?>" id="ccs-logout">
                           Çıkış Yap
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
