<?php require_once "header.php";
$adminControl = adminControl($session::get("ccs-admin-token"));
if($adminControl["response"] == true){ ?>
    <main style="margin-top: 100px !important; margin-bottom: 100px;">
        <div class="container">
            <section class="text-center">
                <div class="row justify-content-end text-end">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="add-blog.php" class="btn btn-success my-btn">Blog Ekle</a>
                    </div>
                </div>
                <h4 class="mb-5"><strong>Bloglar</strong></h4>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kategori Adı</th>
                                <th scope="col">Blog Adı</th>
                                <th scope="col" class="text-center">Düzenle</th>
                                <th scope="col" class="text-end">Sil</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $allBlogs = $db->getRows("SELECT * FROM blogs");
                            if($allBlogs[0] > 0){
                                $counter = 1;
                                foreach ($allBlogs[1] as $blog){
                                    $getCategory = $db->getRow("SELECT * FROM categories WHERE id = ?", [$blog["category_id"]]);
                                    $categoryName = $getCategory[1]["name"]; ?>
                                    <tr>
                                        <th scope="row"><?= $counter; ?></th>
                                        <td><?= $categoryName; ?></td>
                                        <td><?= $blog["name"]; ?></td>
                                        <td class="text-center">
                                            <a href="edit-blog.php?blogId=<?= $blog["id"]; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="text-end">
                                            <a class="delete-blog" id="<?= $blog["id"]; ?>" style="cursor: pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                $counter++;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <?php
}else{
    redirect("/ccs-admin/login.php");
}
require_once "footer.php"; ?>