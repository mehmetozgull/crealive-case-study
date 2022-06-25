<?php require_once "header.php"; ?>
    <main style="    margin-top: 100px !important;">
        <div class="container">
            <section class="text-center">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="mb-5 text-start"><strong>Bloglar</strong></h4>
                    </div>
                    <?php
                    $getCategory = $security::security("category");
                    if($getCategory != ""){
                        $getCategoryId = $db->getRow("SELECT * FROM categories WHERE name_seo = ?", [$getCategory]);
                        if($getCategoryId[0] > 0){
                            $catId = $getCategoryId[1]["id"];
                            $catNameSeo = $getCategoryId[1]["name_seo"];
                        }else{
                            $catId = 0;
                            $catNameSeo = "";
                        }
                    }else{
                        $catNameSeo = "";
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="categories" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategoriler
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categories">
                                <?php
                                $getCategories = $db->getRows("SELECT * FROM categories");
                                if($getCategories[0] > 0){ ?>
                                    <?php foreach ($getCategories[1] as $category){ ?>
                                        <li><a class="dropdown-item <?= $category["name_seo"] == $catNameSeo ? "active" : ""; ?>" href="?category=<?= $category["name_seo"] ?>"><?= $category["name"] ?></a></li>
                                    <?php }
                                }else{ ?>
                                    <li><a class="dropdown-item">Önce Kategori Ekle!</a></li>
                                <?php } ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $siteUrl; ?>">Hepsi</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if(isset($catId) && $catId != ""){
                        $blogs = $db->getRows("SELECT * FROM blogs WHERE category_id = ?", [$catId]);
                    }else{
                        $blogs = $db->getRows("SELECT * FROM blogs");
                    }
                    if($blogs[0] > 0){
                        foreach ($blogs[1] as $blog){
                            $category = $db->getRow("SELECT * FROM categories WHERE id = ?", [$blog["category_id"]]);
                            ?>
                            <div class="col-lg-4 col-md-12 mb-4">
                                <div class="card">
                                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                        <img src="assets/img/<?= $blog["thumbnail"] ?>" alt="<?= $blog["name"] ?>" class="img-fluid" />
                                        <a href="blog-detail.php?id=<?= $blog["id"]; ?>">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $blog["name"] ?></h5>
                                        <p class="card-text">
                                            Kategori: <?= $category[1]["name"] ?>
                                        </p>
                                        <p class="card-text">
                                            Tarih: <?= dmy($blog["timestamp"]) ?>
                                        </p>
                                        <a href="blog-detail.php?id=<?= $blog["id"]; ?>" class="btn btn-primary">Read</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }else{ ?>
                        <div class="col-lg-4 col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Blog Bulunmamaktadır.</h5>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </section>
        </div>
    </main>
<?php require_once "footer.php"; ?>