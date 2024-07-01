<?php require_once __DIR__ . '/../public/header.php' ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= url('user/signin') ?>">
    <div class="mb-3">
        <label for="username" class="form-label">账号</label>
        <input type="text" class="form-control" name="username" id="username" required placeholder="请输入账号"
               maxlength="20">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">密码</label>
        <input type="password" name="password" class="form-control" id="password" required placeholder="请输入密码">
    </div>
    <div class="mb-3">
        <label for="captcha" class="form-label">验证码</label>
        <div class="d-flex align-items-center">
            <input type="text" name="captcha" class="form-control flex-grow-1" required id="captcha"
                   placeholder="请输入验证码">
            <div class="ms-2"><?= captcha_img() ?></div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">登录</button>
    </div>
</form>
<?php require_once __DIR__ . '/../public/footer.php' ?>
