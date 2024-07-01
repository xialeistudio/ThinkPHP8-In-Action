<?php require_once __DIR__ . '/../public/header.php' ?>
    <form method="post" action="<?= url('user/do_add') ?>" class="col-4 mt-2">
        <div class="mb-3">
            <label for="realname" class="form-label">姓名</label>
            <input type="text" class="form-control" name="realname" id="realname" required placeholder="请输入姓名" maxlength="20">
        </div>
        <div class="mb-3">
            <label for="sex" class="form-label">性别</label>
            <select name="sex" id="sex" class="form-control">
                <option value="1">男</option>
                <option value="2">女</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">手机号</label>
            <input type="text" class="form-control" name="phone" id="phone" required placeholder="请输入手机号" maxlength="11">
        </div>
        <div class="text-start">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
<?php require_once __DIR__ . '/../public/footer.php' ?>