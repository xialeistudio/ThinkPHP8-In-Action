<?php require_once __DIR__ . '/../public/header.php' ?>
<form action="<?= url('/admin/do_changepwd') ?>" method="post" class="col-4">
    <div class="mb-3">
        <label for="old_password" class="form-label">当前密码</label>
        <input type="password" class="form-control" name="old_password" id="old_password" required placeholder="请输入当前密码"
               maxlength="40">
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">新密码</label>
        <input type="password" class="form-control" name="new_password" id="new_password" required placeholder="请输入新密码"
               maxlength="40">
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">确认密码</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required placeholder="请再次输入新密码"
               maxlength="40">
    </div>
    <div class="text-start">
        <button type="submit" class="btn btn-primary">提交</button>
    </div>
</form>
<?php require_once __DIR__ . '/../public/footer.php' ?>
