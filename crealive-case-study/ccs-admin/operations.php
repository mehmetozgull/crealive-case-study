<?php
ob_start(); session_start();
require_once "../classes/allClass.php";
require_once "../functions/functions.php";
$db = new ccs\db\Database();
$security = new ccs\security\Security();
$session = new ccs\security\Session();
$token = new ccs\security\Token();
$siteUrl = $db->settings("url");
$adminControl = adminControl($session::get("ccs-admin-token"));
if($adminControl["response"] == true){
    if (isset($_GET["operation"])) {
        $operation = $security::security("operation");
        if ($operation != "") {
            $timeStamp = time();
            switch ($operation) {
                case 'add-blog':
                    if ($security::control("POST")) {
                        $categoryId = $security::security("category-id");
                        $blogName = $security::security("blog-name");
                        $blogText = $security::security("blog-text");
                        $ccsToken = $security::security("ccs-token");
                        if($token::control($ccsToken)){
                            if($categoryId != "" && $blogName != "" && $blogText != "") {
                                $categoryControl = $db->getRow("SELECT * FROM categories WHERE id = ?", [$categoryId]);
                                if ($categoryControl[0] > 0) {
                                    $blogThumb = $_FILES["blog-thumb"];
                                    if ($blogThumb["name"] != "" && $blogThumb["type"] != "" && $blogThumb["tmp_name"] != "" && $blogThumb["error"] == 0 && $blogThumb["size"] > 0) {
                                        if (imgExtensionControl($blogThumb["type"])) {
                                            $imgName = createImageName($blogThumb["name"]);
                                            $thumbnailOnlyImgName = $imgName["onlyImageName"];
                                            $thumbnailFullImgName = $imgName["fullImageName"];
                                        } else {
                                            die("Lütfen bir görsel (png, jpg, webp) yükleyiniz.:::error:::");
                                        }

                                        $insertBlog = $db->dbInsert("INSERT INTO blogs (category_id, name, thumbnail, text, timestamp) VALUES (?, ?, ?, ?, ?)", [$categoryId, $blogName, $thumbnailFullImgName, $blogText, $timeStamp]);
                                        if ($insertBlog > 0) {
                                            $img = new ccs\verot\upload($blogThumb, "tr-TR");
                                            if ($img->uploaded) {
                                                $img->mime_magic_check = true;
                                                $img->allowed = array("image/*");
                                                $img->file_new_name_body = $thumbnailOnlyImgName;
                                                $img->file_overwrite = true;
                                                $img->process("../assets/img");
                                                if ($img->processed) {
                                                    $img->clean();
                                                    echo "Blog başarıyla eklendi!:::success:::" . $insertBlog;
                                                } else {
                                                    die("Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error:::");
                                                }
                                            }
                                        } else {
                                            echo "Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error:::";
                                        }
                                    } else {
                                        echo "Lütfen görsel (png, jpg, webp) yükleyiniz:::error:::";
                                    }
                                } else {
                                    echo "Lütfen kategori seçiniz:::error:::";
                                }
                            }else{
                                echo "Lütfen tüm alanları doldurunuz!:::error:::";
                            }
                        }else{
                            echo "Yetkisiz giriş! CCS-Token eksik!:::error:::";
                        }
                    }else{
                        redirect("/ccs-admin/");
                    }
                    break;
                case 'edit-blog':
                    if ($security::control("POST")) {
                        $categoryId = $security::security("category-id");
                        $blogId = $security::security("blog-id");
                        $blogName = $security::security("blog-name");
                        $blogText = $security::security("blog-text");
                        $ccsToken = $security::security("ccs-token");
                        if($token::control($ccsToken)){
                            if($blogId != "" && $categoryId != "" && $blogName != "" && $blogText != ""){
                                $categoryControl = $db->getRow("SELECT * FROM categories WHERE id = ?", [$categoryId]);
                                if($categoryControl[0] > 0){
                                    $blogThumb = $_FILES["blog-thumb"];
                                    $getThumbnailPath = $db->getRow("SELECT id, thumbnail FROM blogs WHERE id = ? LIMIT 1", [$blogId]);
                                    if($blogThumb["name"] != "" && $blogThumb["type"] != "" && $blogThumb["tmp_name"] != "" && $blogThumb["error"] == 0 && $blogThumb["size"] > 0){
                                        if(imgExtensionControl($blogThumb["type"])){
                                            $yeniResim = true;
                                            $imgName = createImageName($blogThumb["name"]);
                                            $thumbnailOnlyImgName = $imgName["onlyImageName"];
                                            $thumbnailFullImgName = $imgName["fullImageName"];
                                        }else{
                                            die("Lütfen bir görsel (png, jpg, webp) yükleyiniz.:::error:::");
                                        }
                                    }else{
                                        $yeniResim = false;
                                        $thumbnailFullImgName = $getThumbnailPath[1]["thumbnail"];
                                    }

                                    $updateBlog = $db->dbUpdate("UPDATE blogs SET category_id = ?, name = ?, thumbnail = ?, text = ?, timestamp = ? WHERE id = ? LIMIT 1", [$categoryId, $blogName, $thumbnailFullImgName, $blogText, $timeStamp, $blogId]);
                                    if($updateBlog > 0){
                                        if($yeniResim){
                                            $img = new ccs\verot\upload($blogThumb, "tr-TR");
                                            if ($img->uploaded) {
                                                $img->mime_magic_check = true;
                                                $img->allowed = array("image/*");
                                                $img->file_new_name_body = $thumbnailOnlyImgName;
                                                $img->file_overwrite = true;
                                                $img->process("../assets/img");
                                                if ($img->processed) {
                                                    $oldImagePath = "../assets/img/" . $getThumbnailPath[1]["thumbnail"];
                                                    unlink($oldImagePath);
                                                    $img->clean();
                                                    die("Blog başarıyla güncellendi!:::success:::" . $blogId);
                                                } else {
                                                    die("Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error:::");
                                                }
                                            }
                                        }
                                        die("Blog başarıyla güncellendi!:::success:::" . $blogId);
                                    }else{
                                        echo "Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error:::";
                                    }
                                }else{
                                    echo "Lütfen kategori seçiniz:::error:::";
                                }
                            }else{
                                echo "Lütfen tüm alanları doldurunuz!:::error:::";
                            }
                        }else{
                            echo "Yetkisiz giriş! CCS-Token eksik!:::error:::";
                        }
                    }else{
                        redirect("/ccs-admin/");
                    }
                    break;
                case 'delete-blog':
                    if ($security::control("POST")) {
                        $blogId = $security::security("blogId");
                        if($blogId != ""){
                            $getBlog = $db->getRow("SELECT * FROM blogs WHERE id = ? LIMIT 1", [$blogId]);
                            if($getBlog[0] > 0){
                                $thumbnail = $getBlog[1]["thumbnail"];
                                $deleteBlog = $db->dbDelete("DELETE FROM blogs WHERE id = ? LIMIT 1", [$blogId]);
                                if($deleteBlog > 0){
                                    $oldImagePath = "../assets/img/" . $thumbnail;
                                    unlink($oldImagePath);
                                    die("Blog başarıyla silindi.:::success");
                                }else{
                                    die("Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error");
                                }
                            }else{
                                die("Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error");
                            }
                        }else{
                            die("Beklenmedik bir hata oluştu. Lütfen tekrar deneyiniz.:::error");
                        }
                    }else{
                        redirect("/ma-admin/");
                    }
                        break;
            }
        }else{
            redirect("/ccs-admin/");
        }
    }else{
        redirect("/ccs-admin/");
    }
}else{
    redirect("/ccs-admin/login.php");
}
ob_end_flush();