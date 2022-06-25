<?php
ob_start(); session_start();
require_once "../classes/allClass.php";
require_once "functions.php";
$db = new ccs\db\Database();
$security = new ccs\security\Security();
$session = new ccs\security\Session();
$token = new ccs\security\Token();
$siteUrl = $db->settings("url");
if(isset($_GET["operation"])){
    $operation = $security::security("operation");
    if($operation != ""){
        switch ($operation){
            case 'admin-login':
                if($security::control("POST")) {
                    $email = $security::security("e-mail");
                    $pass = securityPass($_POST["password"]);
                    $ccsToken = $security::security("ccs-token");
                    if(($email != "") && ($pass != "")){
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                            if($token::control($ccsToken)){
                                $md5pass = md5($pass);
                                $adminControl = $db->getRow("SELECT * FROM settings WHERE email = ? AND password = ?", [$email, $md5pass]);
                                if($adminControl[0] > 0){
                                    $session::create("ccs-admin-token",$email);
                                    echo "Giriş yapıldı!:::success";
                                }else{
                                    echo "Email veya şifre yanlış!:::error";
                                }
                            }else{
                                echo "Yetkisiz giriş! CCS-Token eksik!:::error:::";
                            }
                        }else{
                            echo "Geçerli bir e-posta adresi giriniz!:::error";
                        }

                    }else{
                        echo "Lütfen tüm alanları doldurunuz.:::error";
                    }
                }else{
                    redirect();
                }
                break;
            case 'admin-logout':
                if($security::control("POST")) {
                    $email = $security::security("email");
                    if($email != "" && $session::isHave("ccs-admin-token")){
                        if($session::get("ccs-admin-token") == $email){
                        $ssControl = $db->getRow("SELECt * FROM settings WHERE email = ?  LIMIT 1", [$email]);
                        if($ssControl[0] > 0){
                            $session::del("ccs-admin-token");
                            echo "Çıkış yapıldı:::success";
                        }else{
                            echo "Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error";
                        }
                        }else{
                            echo "Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error";
                        }
                    }else{
                        echo "Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error";
                    }
                }else{
                    redirect();
                }
                break;
        }
    }else{
        redirect();
    }
}else{
    redirect();
} ?>
