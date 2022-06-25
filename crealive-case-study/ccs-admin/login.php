<?php
ob_start(); session_start();
require_once "../classes/allClass.php";
require_once "../functions/functions.php";
$db = new ccs\db\Database();
$session = new ccs\security\Session();
$token = new ccs\security\Token();
$siteUrl = $db->settings("url");
if($session::isHave("ccs-admin-token")){
    $ssControl = $db->getRow("SELECT * FROM settings WHERE email = ? LIMIT 1", [$session::get("ccs-admin-token")]);
    if($ssControl[0] > 0){
        redirect("/ccs-admin/");
    }else{
        $session::del("ccs-admin-token");
        redirect("/ccs-admin/login.php");
    }
}else{
?>
<!doctype html>
<html lang="tr-TR">
<head>
    <meta http-equiv="Content-Type" content="text/html charset=utf-8">
    <meta http-equiv="Content-Language" content="tr">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta charset="utf-8">
    <title><?= $db->settings("title"); ?></title>
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
                <a class="navbar-brand" href="<?= $siteUrl; ?>" style="margin-top: -3px;">
                    Crealive Blog Case
                </a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
                        aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </nav>
    </header>
    <main style="margin-top: 300px !important;">
        <div class="container">
            <section class="text-center">
            <h4 class="mb-5"><strong>Admin Panele Giriş Yap</strong></h4>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-12 mb-4">
                    <form method="post" id="adminLoginForm">
                        <input type="hidden" name="ccs-token" value="<?= $token::createToken(); ?>">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="e-mail" placeholder="name@example.com" name="e-mail">
                            <label for="e-mail">E-posta</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="pass" placeholder="Password" name="password">
                            <label for="pass">Parola</label>
                        </div>
                        <div class="mt-4">
                            <button type="button" id="adminLoginBtn" class="btn btn-success">Giriş Yap <span class="adminLoginLoad"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        </div>
    </main>
<footer class="text-lg-start">
    <div class="text-center p-3">
        © <?= date("Y"); ?> Copyright:
        <a class="text-dark" target="_blank" href="https://mehmetozgul.com/">mehmetozgul.com</a>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
<?php
}
ob_end_flush();
?>