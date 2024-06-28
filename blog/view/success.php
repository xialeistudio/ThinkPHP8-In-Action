<?php require_once __DIR__ . '/public/header.php' ?>
    <div class="alert alert-success"><?= $msg ?></div>
<?php if (empty($callback)): ?>
    <p><a class="btn btn-primary" href="<?= request()->header('referer') ?>">返回</a></p>
<?php else: ?>
    <p><a class="btn btn-primary" href="<?= $callback ?>">返回</a></p>
<?php endif ?>
<?php require_once __DIR__ . '/public/footer.php' ?>