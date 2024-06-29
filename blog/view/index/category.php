<?php require_once __DIR__ . '/../public/header.php' ?>

    <div class="container mt-5">
        <div class="list-group">
            <?php foreach ($list as $row): ?>
                <a href="<?= url('/index', ['category_id' => $row['category_id']]) ?>" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">
                        #<?= $row['category_id'] ?> <?= $row['name'] ?>
                    </h5>
                    <span class="badge rounded-pill bg-light text-dark">
                    文章数: <?= $row['posts'] ?>
                </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <nav class="mt-3">
        <?= $page ?>
    </nav>

<?php require_once __DIR__ . '/../public/footer.php' ?>