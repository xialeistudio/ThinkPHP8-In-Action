<?php require_once __DIR__ . '/../public/header.php' ?>
<?php if (empty($list)): ?>
    <p>暂时没有日志</p>
<?php else: ?>
    <table class="table table-bordered table-striped mt-2">
        <tr>
            <td>日志内容</td>
            <td>时间</td>
            <td>IP</td>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['msg'] ?></td>
                <td><?= $item['created_at'] ?></td>
                <td><?= $item['created_ip'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif ?>
    <nav>
        <?= $page ?>
    </nav>
<?php require_once __DIR__ . '/../public/footer.php' ?>