<?php require_once __DIR__ . '/public/header.php' ?>
<div class="alert alert-danger"><?=$msg?></div>
<p><a class="btn btn-primary" href="<?=request()->header('referer')?>">返回</a></p>
<?php require_once __DIR__ . '/public/footer.php' ?>