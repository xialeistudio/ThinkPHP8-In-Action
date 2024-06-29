<?php require_once __DIR__ . '/../public/header.php' ?>

    <div class="container mt-1">
        <div class="post">
            <h1 class="display-6"><?= $post['title'] ?></h1>
            <div class="d-flex align-items-center text-muted mb-3">
                <a class="text-decoration-none text-dark" href="<?= url('/index', ['user_id' => $post['user_id']]) ?>">
                    <?= $post['user']['username'] ?>
                </a>
                <span class="mx-2">·</span>
                <a class="text-decoration-none text-dark" href="<?= url('/index', ['category_id' => $post['category_id']]) ?>">
                    <?= $post['category']['name'] ?>
                </a>
                <span class="mx-2">·</span>
                <time class="small"><?= $post['created_at'] ?></time>
            </div>

            <div class="border p-3 mb-3 rounded-3" style="background-color: #f8f9fa;">
                <?= $post['content'] ?>
            </div>

            <div class="d-flex align-items-center mb-3">
                <div>
                    <span><?= $post['praise_count'] ?>人</span>
                    <a class="text-decoration-none" href="<?= url('/index/praise', ['post_id' => $post['post_id']]) ?>">点赞</a>
                </div>
                <div class="ms-auto">
                    <span class="me-2"><?= $post['comment_count'] ?>人评论</span>
                </div>
            </div>

            <strong class="mb-2">评论列表</strong>
            <?php if (empty(session('user'))): ?>
                <p>登录后才能评论</p>
            <?php else: ?>
                <form class="mb-3" action="<?= url('/index/comment', ['post_id' => $post['post_id']]) ?>" method="post">
                    <div class="form-floating mb-3">
                        <textarea name="content" class="form-control" id="content" style="height: 100px" required></textarea>
                        <label for="content">评论内容</label>
                    </div>
                    <button type="submit" class="btn btn-primary">发表评论</button>
                </form>
            <?php endif; ?>

            <div class="list-group mt-3">
                <?php foreach ($comments as $comment): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= $comment['user']['username'] ?></h5>
                            <small class="text-muted"><?= $comment['created_at'] ?></small>
                        </div>
                        <p class="mb-1"><?= $comment['content'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../public/footer.php' ?>