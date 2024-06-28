<?php require_once __DIR__ . '/../public/header.php' ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= request()->url() ?>">
    <div class="mb-3">
        <label for="password" class="form-label">新密码</label>
        <input type="password" name="password" class="form-control" id="password" required placeholder="请输入新密码">
    </div>
    <div class="mb-3">
        <label for="password2" class="form-label">确认密码</label>
        <input type="password" name="password2" class="form-control" id="password2" required placeholder="请再次输入新密码">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">修改</button>
    </div>
</form>
<?php require_once __DIR__ . '/../public/footer.php' ?>
