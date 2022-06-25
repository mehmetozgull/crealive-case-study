<?php require_once "header.php";
$adminControl = adminControl($session::get("ccs-admin-token"));
if($adminControl["response"] == true){
    if(isset($_GET["blogId"]) && security($_GET["blogId"]) != ""){
        $blogId = security($_GET["blogId"]);
        $blog = $db->getRow("SELECT * FROM blogs WHERE id = ?",[$blogId]);
        if($blog[0] > 0){ ?>
        <main style="margin-top: 100px !important;">
            <div class="container">
                <section>
                    <h4 class="mb-5"><strong>Blog Düzenle</strong></h4>
                    <div class="row">
                        <form id="editBlogForm" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="ccs-token" id="ccs-token" value="<?= $token::createToken(); ?>">
                            <input type="hidden" name="blog-id" value="<?= $blog[1]["id"] ?>">
                            <?php
                            $allCategories = $db->getRows("SELECT * FROM categories"); ?>
                                <div class="mb-4">
                                    <select class="form-select my-input" name="category-id">
                                        <option>Blog Kategorisi Seçin</option>
                                <?php foreach ($allCategories[1] as $category){ ?>
                                        <option <?= $category["id"] == $blog[1]["category_id"] ? "selected" : ""; ?> value="<?= $category["id"]; ?>"><?= $category["name"]; ?></option>
                                <?php } ?>
                                    </select>
                                </div>
                            <div class="mb-4">
                                <label for="blog-name" class="form-label my-label">Blog Adı</label>
                                <input type="text" class="form-control my-input" id="blog-name" name="blog-name" value="<?= $blog[1]["name"]; ?>">
                            </div>
                            <div class="mb-4 thumbnail-upload">
                                <div class="thumbnail-preview img-fluid" style="display: inherit">
                                    <div id="thumbnailImagePreview" style="background-image: url(<?= "../assets/img/" . $blog[1]["thumbnail"]; ?>);">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label for="blog-thumb" class="form-label my-label">Blog Thumbnail</label>
                                    <input class="form-control my-input" type="file" id="blog-thumb" name="blog-thumb" accept=".png, .jpeg, .jpg, .webp">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="blog-text" class="form-label my-label">Blog Text</label>
                                <textarea class="form-control my-input" name="blog-text" id="blog-text" rows="15"><?= $blog[1]["text"]; ?></textarea>
                            </div>
                            <div class="mb-4">
                                <button type="button" id="editBlogBtn" class="btn btn-success">Kaydet <span class="editBlogLoad"></span></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    <?php
        }else{
            redirect("/ccs-admin/");
        }
    }else{
        redirect("/ccs-admin/");
    }
}else{
    redirect("/ccs-admin/login.php");
}
require_once "footer.php"; ?>