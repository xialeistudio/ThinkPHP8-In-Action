<?php require_once __DIR__ . '/../../public/header.php' ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= request()->url() ?>">
    <div class="mb-3">
        <label for="name" class="form-label">名称</label>
        <input type="text" name="name" id="name" class="form-control" required maxlength="20"
               value="<?= $category['name'] ?>" placeholder="请输入名称">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">状态</label>
        <select class="form-select" name="status" id="status">
            <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ?>>启用</option>
            <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ?>>禁用</option>
        </select>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
</form>
<?php require_once __DIR__ . '/../../public/footer.php' ?>
