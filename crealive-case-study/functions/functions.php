<?php
if(basename($_SERVER["PHP_SELF"]) == basename(__FILE__)){
    header("Location:http://" . $_SERVER["SERVER_NAME"] . pathinfo($_SERVER["PHP_SELF"])["dirname"] . "/..");
    exit();
}

function redirect($url=""){
    global $db;
    $siteUrl = $db->settings("url");
    header('Location:' . $siteUrl . $url);
    exit();
}

function security($text){
    $deleteSpace 	=	trim($text);
    $clearTags      =	strip_tags($deleteSpace);
    $clearSlash     =   stripslashes($clearTags);
    $result 	    =	htmlspecialchars($clearSlash, ENT_QUOTES);
    return $result;
}

function securityPass($text){
    $deleteSpace 	=	trim($text);
    $result         =	strip_tags($deleteSpace);
    return $result;
}

function imgExtensionControl($imgType) {
    $expImageType = explode("/", $imgType);
    $type = end($expImageType);
    $result = (($type == "png") or ($type == "jpeg") or ($type == "webp")) ? true : false;
    return $result;
}

function createImageName($imgName){
    $imgNameArr = explode(".", $imgName);
    $ext = "." . end($imgNameArr);
    $onlyImageName = substr(md5(uniqid(time())), 0, 25);
    $fullImageName = $onlyImageName . $ext;
    return ["onlyImageName" => $onlyImageName, "fullImageName" => $fullImageName];
}

function adminControl($session){
    global $db;
    if($session == false){
        return ["response" => false];
    }
    $ssControl = $db->getRow("SELECt * FROM settings WHERE email = ? LIMIT 1", [$session]);
    if($ssControl[0] > 0){
        return ["response" => true, "data" =>$ssControl[1]];
    }else{
        return ["response" => false];
    }
}

function dmy($value){
    $aylar = array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
    $ay = $aylar[date("m", $value) - 1];
    $result = date("d ", $value) . $ay . date(" Y", $value);
    return $result;
}

?>
