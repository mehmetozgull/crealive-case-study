<?php require_once "header.php";
$adminControl = adminControl($session::get("ccs-admin-token"));
if($adminControl["response"] == true){ ?>
    <main style="    margin-top: 100px !important;">
        <div class="container">
            <section>
                <h4 class="mb-5"><strong>Blog Ekle</strong></h4>
                <div class="row">
                    <form id="addBlogForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="ccs-token" value="<?= $token::createToken(); ?>">
                        <?php
                        $allCategories = $db->getRows("SELECT * FROM categories");
                        if($allCategories[0] > 0){ ?>
                            <div class="mb-4">
                                <select class="form-select my-input" name="category-id">
                                    <option selected>Blog Kategorisi Seçin</option>
                            <?php foreach ($allCategories[1] as $category){ ?>
                                    <option value="<?= $category["id"]; ?>"><?= $category["name"]; ?></option>
                            <?php } ?>
                                </select>
                            </div>
                        <?php }else{ ?>
                            <div class="mb-4">
                                BLOG EKLEMEK İÇİN İLK ÖNCE KATEGORİ EKLEYİN!
                            </div>
                        <?php } ?>
                        <div class="mb-4">
                            <label for="blog-name" class="form-label my-label">Blog Adı</label>
                            <input type="text" class="form-control my-input" id="blog-name" name="blog-name">
                        </div>
                        <div class="mb-4 thumbnail-upload">
                            <div class="thumbnail-preview img-fluid">
                                <div id="thumbnailImagePreview">
                                </div>
                            </div>
                            <div class="mt-2">
                                <label for="blog-thumb" class="form-label my-label">Blog Thumbnail</label>
                                <input class="form-control my-input" type="file" id="blog-thumb" name="blog-thumb" accept=".png, .jpeg, .jpg, .webp">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="blog-text" class="form-label my-label">Blog Text</label>
                            <textarea class="form-control my-input" name="blog-text" id="blog-text" rows="15"></textarea>
                        </div>
                        <div class="mb-4">
                            <button type="button" id="addBlogBtn" class="btn btn-success">Kaydet <span class="addBlogLoad"></span></button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <?php
}else{
    redirect("/ccs-admin/login.php");
}
require_once "footer.php"; ?>