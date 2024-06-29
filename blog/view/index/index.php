<?php require_once __DIR__ . '/../public/header.php' ?>

    <div class="container mt-5">
        <div class="row">
            <?php foreach ($list as $row): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a class="text-reset text-decoration-none" href="<?= url('/index/post', ['id' => $row['post_id']]) ?>">
                                    #<?= $row['post_id'] ?> <?= $row['title'] ?>
                                </a>
                            </h5>
                            <p class="card-text">
                            <ul class="list-inline mb-2 small">
                                <li class="list-inline-item"><span class="text-muted"><?=$row['praise_count']?>人点赞</span></li>
                                <li class="list-inline-item">|</li>
                                <li class="list-inline-item"><span class="text-muted"><?=$row['comment_count']?>人评论</span></li>
                            </ul>
                            <div class="d-flex justify-content-between small text-muted">
                                <div>
                                    <a class="text-decoration-none" href="<?= url('/index', ['user_id' => $row['user_id']]) ?>">
                                        <?= $row['user']['username'] ?>
                                    </a>
                                </div>
                                <time class="fst-italic" datetime="<?= $row['created_at'] ?>">
                                    <?= date('Y-m-d H:i', strtotime($row['created_at'])) ?>
                                </time>
                            </div>
                            </p>
                        </div>
                        <div class="card-footer text-muted">
                            <a href="<?= url('/index', ['category_id' => $row['category_id']]) ?>">
                                <?= $row['category']['name'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <nav class="d-flex justify-content-center mt-3">
            <?= $page ?>
        </nav>
    </div>

<?php require_once __DIR__ . '/../public/footer.php' ?>