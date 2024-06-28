<?php use app\model\Category;

require_once __DIR__ . '/../../public/header.php' ?>

<div class="mt-2">
    <a class="btn btn-primary rounded-pill" href="<?= url('/user.category/create') ?>">添加分类</a>
    <a class="btn btn-secondary rounded-pill" href="<?= url('/user') ?>">文章列表</a>
</div>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>状态</th>
        <th>文章数</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php foreach ($list as $row): ?>
        <tr>
            <td><?= $row['category_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>
                <?php if ($row['status'] == Category::STATUS_VISIBLE): ?>
                    <span class="badge text-bg-success">启用</span>
                <?php else: ?>
                    <span class="badge text-bg-secondary">禁用</span>
                <?php endif; ?>
            </td>
            <td><?= $row['posts'] ?></td>
            <td>
                <a class="btn btn-sm btn-secondary" href="<?= url('/user.category/edit', ['id' => $row['category_id']]) ?>">编辑</a>
                <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗?')" href="<?= url('/user.category/delete', ['id' => $row['category_id']]) ?>">删除</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php require_once __DIR__ . '/../../public/footer.php' ?>
