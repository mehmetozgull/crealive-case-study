<?php

namespace ccs\security;
use \ccs\security\Session as Session;

class Token extends Session{
    public static function createToken(){
        return parent::create("CCS-Token", md5(uniqid(mt_rand())));
    }
    public static function control($token){
        if(parent::isHave("CCS-Token") && $token == parent::get("CCS-Token") && hash_equals(parent::get("CCS-Token"), $token)){
            return true;
        }else{
            return false;
        }
    }
}