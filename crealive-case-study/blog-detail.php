<?php require_once "header.php";
if($security::control("GET")){
    $blogId = $security::security("id");
    if($blogId != ""){
        $blog = $db->getRow("SELECT * FROM blogs WHERE id = ?", [$blogId]);
        if($blog[0] > 0){
            $category = $db->getRow("SELECT * FROM categories WHERE id = ?", [$blog[1]["category_id"]]); ?>
        <main style="    margin-top: 100px !important;">
            <div class="container">
                <section class="text-center">
                    <h4 class="mb-4 text-center"><strong><?= $blog[1]["name"] ?></strong></h4>
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-12 mb-4">
                            <div class="card">
                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                    <img src="assets/img/<?= $blog[1]["thumbnail"] ?>" alt="<?= $blog[1]["name"] ?>" class="img-fluid" />
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <p class="card-text">
                                        Kategori: <?= $category[1]["name"] ?>
                                    </p>
                                    <p class="card-text">
                                        Tarih: <?= dmy($blog[1]["timestamp"]) ?>
                                    </p>
                                    <p class="card-text">
                                        <?= $blog[1]["text"] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
<?php
        }else{
            redirect();
        }
    }else{
        redirect();
    }
}else{
    redirect();
}
require_once "footer.php"; ?>