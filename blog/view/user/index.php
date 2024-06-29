<?php require_once __DIR__ . '/../public/header.php' ?>

<div class="mt-2">
    <a class="btn btn-primary rounded-pill" href="<?= url('/user.post/publish') ?>">发表文章</a>
    <a class="btn btn-secondary rounded-pill" href="<?= url('/user.category/index') ?>">分类列表</a>
</div>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th>状态</th>
        <th>置顶</th>
        <th>排序</th>
        <th>点赞数</th>
        <th>评论数</th>
        <th>分类</th>
        <th>发表时间</th>
        <th>最后更新</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php foreach ($postList as $row): ?>
        <tr>
            <td><?= $row['post_id'] ?></td>
            <td><a target="_blank" href="<?= url('/post/detail', ['id' => $row['post_id']]) ?>"><?= $row['title'] ?></a>
            </td>
            <td>
            <?php if ($row['status'] == 1): ?>
                <span class="badge text-bg-secondary">草稿</span>
            <?php elseif ($row['status'] == 2): ?>
                <span class="badge text-bg-success">已发布</span>
            <?php else: ?>
                <span class="badge text-bg-warning">未发布</span>
            <?php endif; ?>
            </td>
            <td>
                <?php if ($row['top'] == 1): ?>
                    <span class="badge text-bg-success">置顶</span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td><?= $row['sort'] ?></td>
            <td><?= $row['praise_count'] ?></td>
            <td><?= $row['comment_count'] ?></td>
            <td><?= $row['category']['name'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td><?= $row['updated_at'] ?></td>
            <td>
                <a class="btn btn-sm btn-secondary"
                   href="<?= url('/user.post/edit', ['id' => $row['post_id']]) ?>">编辑</a>
                <a class="btn btn-danger btn-sm" onclick="return confirm('确认删除吗?')"
                   href="<?= url('/user.post/delete', ['id' => $row['post_id']]) ?>">删除</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<nav>
    <?= $postPager ?>
</nav>
<?php require_once __DIR__ . '/../public/footer.php' ?>
