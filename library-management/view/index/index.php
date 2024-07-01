<?php require_once __DIR__ . '/../public/header.php' ?>
    <div class="d-flex align-items-center justify-content-between mt-2">
        <form action="" class="row flex-fill" method="get">
            <div class="col">
                <select name="status" id="status" class="form-control">
                    <option value="" <?= request()->get('status') === '' ? 'selected' : '' ?>>全部状态</option>
                    <option value="0" <?= request()->get('status') === '0' ? 'selected' : '' ?>>正常</option>
                    <option value="1" <?= request()->get('status') === '1' ? 'selected' : '' ?>>已出借</option>
                </select>
            </div>
            <div class="col">
                <input type="search" class="form-control" placeholder="书名、作者、出版社模糊搜索" id="keyword" name="keyword"
                       value="<?= request()->get('keyword', '') ?>">
            </div>
            <div class="col">
                <button class="btn btn-secondary rounded-pill px-4" type="submit">筛选</button>
                <a class="btn btn-secondary rounded-pill" href="<?=url('/')?>">所有书籍</a>
            </div>
        </form>
        <a href="<?= url('/book/add') ?>" class="btn btn-primary rounded-pill">添加书籍</a>
    </div>
    <hr>
<?php if (empty($list)): ?>
    <p>暂时没有书籍</p>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <tr>
            <td>ID</td>
            <td>ISBN</td>
            <td>标题</td>
            <td>作者</td>
            <td>出版社</td>
            <td>价格</td>
            <td>状态</td>
            <td>添加时间</td>
            <td>最后更新时间</td>
            <td>操作</td>
        </tr>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?= $item['book_id'] ?></td>
                <td><?= $item['isbn'] ?></td>
                <td><?= $item['title'] ?></td>
                <td><?= $item['author'] ?></td>
                <td><?= $item['publisher'] ?></td>
                <td>￥<?= $item['price'] ?></td>
                <td>
                    <?php if ($item['status'] == 1): ?>
                        <span class="badge bg-secondary">已借出</span>
                    <?php else: ?>
                        <span class="badge bg-success">正常</span>
                    <?php endif ?>
                </td>
                <td><?= $item['created_at'] ?></td>
                <td><?= $item['updated_at'] ?></td>
                <td>
                    <a href="<?= url('/book/edit', ['id' => $item['book_id']]) ?>">编辑</a>
                    <a href="<?= url('/book/logs', ['id' => $item['book_id']]) ?>">日志</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif ?>
    <nav>
        <?= $page ?>
    </nav>
<?php require_once __DIR__ . '/../public/footer.php' ?>