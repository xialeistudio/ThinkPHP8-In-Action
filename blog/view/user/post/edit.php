<?php require_once __DIR__ . '/../../public/header.php' ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= request()->url() ?>">
    <div class="mb-3">
        <label for="category_id" class="form-label">分类</label>
        <select class="form-select" name="category_id" id="category_id">
            <?php foreach ($categories as $category): ?>
                <option <?= $category['category_id'] == $post['category_id'] ? 'selected' : '' ?>
                        value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">标题</label>
        <input type="text" class="form-control" name="title" id="title" required placeholder="请输入标题"
               maxlength="100" value="<?= $post['title'] ?>">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">内容</label>
        <textarea name="content" rows="4" class="form-control" id="content" required
                  placeholder="请输入正文"><?= $post['content'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">状态</label>
        <select class="form-select" name="status" id="status">
            <option value="1" <?= $post['status'] == 1 ? 'selected' : '' ?>>草稿</option>
            <option value="2" <?= $post['status'] == 2 ? 'selected' : '' ?>>发布</option>
            <option value="3" <?= $post['status'] == 3 ? 'selected' : '' ?>>未发布</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="top" class="form-label">置顶</label>
        <select class="form-select" name="top" id="top">
            <option value="0" <?= $post['top'] == 0 ? 'selected' : '' ?>>不置顶</option>
            <option value="1" <?= $post['top'] == 1 ? 'selected' : '' ?>>置顶</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="sort" class="form-label">排序</label>
        <input type="number" class="form-control" name="sort" id="sort" required value="<?= $post['sort'] ?>"
               placeholder="请输入排序">
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">发表</button>
    </div>
</form>
<?php require_once __DIR__ . '/../../public/footer.php' ?>
