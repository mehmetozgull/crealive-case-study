<?php

namespace ccs\security;

class Security{
    public static function control($method){
        switch ($method){
            case 'POST':
                return (!empty($_SERVER["REQUEST_METHOD"] == "POST")) ? true : false;
                break;
            case 'GET':
                return (!empty($_SERVER["REQUEST_METHOD"] == "GET")) ? true : false;
                break;
            default:
                return false;
                break;
        }

    }
    public static function security($value){
        if(isset($_POST[$value])){
            $clean_text = trim($_POST[$value]);
        }elseif (isset($_GET[$value])){
            $clean_text = trim($_GET[$value]);
        }else{
            return false;
        }
        $clean_text = strip_tags($clean_text);
        $clean_text = stripslashes($clean_text);
        $result = htmlspecialchars($clean_text, ENT_QUOTES);
        return $result;
    }

}