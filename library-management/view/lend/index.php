<?php require_once __DIR__ . '/../public/header.php' ?>
    <div class="text-end my-2">
        <a href="<?= url('/lend/add') ?>" class="btn btn-primary rounded-pill">添加借阅</a>
    </div>
<?php if (empty($list)): ?>
    <p>暂时没有借阅记录</p>
<?php else: ?>
    <table class="table table-striped table-bordered">
        <tr>
            <td>书籍</td>
            <td>用户</td>
            <td>出借时间</td>
            <td>应还时间</td>
            <td>实际归还</td>
            <td>备注</td>
            <td>操作</td>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td>
                    <?= $item['book']['title'] ?>/
                    <?= $item['book']['author'] ?>/
                    <?= $item['book']['publisher'] ?>/<?= $item['book']['isbn'] ?>
                </td>
                <td>
                    <?= $item['user']['realname'] ?>/<?= $item['user']['phone'] ?>
                </td>
                <td><?= $item['lending_date'] ?></td>
                <td><?= $item['should_return_date'] ?></td>
                <td>
                    <?php if ($item['return_at'] == 0): ?>
                        <span class="badge text-bg-secondary">未归还</span>
                    <?php else: ?>
                        <span class="badge text-bg-success">已归还</span>
                    <?php endif ?>
                </td>
                <td><?= $item['remark'] ?> </td>
                <td>
                    <a href="<?= url('/lend/update', ['book_id' => $item['book_id'], 'user_id' => $item['user_id']]) ?>">编辑</a>
                    <?php if (empty($item['return_at'])): ?>
                        <a href="<?= url('/lend/return', ['book_id' => $item['book_id'], 'user_id' => $item['user_id']]) ?>"
                           onclick="return confirm('确定操作吗?');">归还</a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif ?>
    <nav>
        <?= $page ?>
    </nav>
<?php require_once __DIR__ . '/../public/footer.php' ?>