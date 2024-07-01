<?php require_once __DIR__ . '/../public/header.php' ?>
    <div class="d-flex align-items-center justify-content-between mt-2">
        <form action="" class="row flex-fill" method="get">
            <div class="col">
                <input type="search" class="form-control" placeholder="姓名、手机号模糊搜索" id="keyword" name="keyword"
                       value="<?= request()->get('keyword', '') ?>">
            </div>
            <div class="col">
                <button class="btn btn-secondary rounded-pill px-4" type="submit">筛选</button>
                <a class="btn btn-secondary rounded-pill" href="<?=url('/user')?>">所有读者</a>
            </div>
        </form>
        <a href="<?= url('/user/add') ?>" class="btn btn-primary rounded-pill">添加读者</a>
    </div>
    <hr>
<?php if (empty($list)): ?>
    <p>暂时没有读者</p>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <tr>
            <td>ID</td>
            <td>姓名</td>
            <td>性别</td>
            <td>手机号</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['user_id'] ?></td>
                <td><?= $item['realname'] ?></td>
                <td>
                    <?php if ($item['sex'] == 1): ?>
                        男
                    <?php else: ?>
                        女
                    <?php endif ?>
                </td>
                <td><?= $item['phone'] ?></td>

                <td><?= $item['created_at'] ?></td>
                <td>
                    <a href="<?= url('/user/edit', ['id' => $item['user_id']]) ?>">编辑</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif ?>
    <nav>
        <?= $page ?>
    </nav>
<?php require_once __DIR__ . '/../public/footer.php' ?>