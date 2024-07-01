<?php require_once __DIR__ . '/../public/header.php' ?>
    <form method="post" action="<?= url('lend/do_update') ?>" class="col-4 mt-2">
        <input type="hidden" name="book_id" value="<?= $lend['book_id'] ?>">
        <input type="hidden" name="user_id" value="<?= $lend['user_id'] ?>">
        <?php if (!empty($lend['return_at'])): ?>
            <input type="hidden" name="lending_date" value="<?= $lend['lending_date'] ?>">
            <input type="hidden" name="should_return_date" value="<?= $lend['should_return_date'] ?>">

        <?php endif; ?>
        <div class="mb-3">
            <label for="book_id" class="form-label">书籍</label>
            <select name="book_id" id="book_id" class="form-control" disabled>
                <?php foreach ($books as $book): ?>
                    <option <?= $lend['book_id'] == $book['book_id'] ? 'selected' : '' ?>
                            value="<?= $book['book_id'] ?>"><?= $book['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">读者</label>
            <select name="user_id" id="user_id" class="form-control" disabled>
                <?php foreach ($users as $user): ?>
                    <option <?= $lend['user_id'] == $user['user_id'] ? 'selected' : '' ?>
                            value="<?= $user['user_id'] ?>"><?= $user['realname'] ?>/<?= $user['phone'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="lending_date" class="form-label">借出日期</label>
            <input type="date" class="form-control" name="lending_date" id="lending_date" required
                   placeholder="请选择借出日期"
                   value="<?= $lend['lending_date'] ?>"
                <?= !empty($lend['return_at']) ? 'disabled' : '' ?>
                   maxlength="20">
        </div>
        <div class="mb-3">
            <label for="should_return_date" class="form-label">应还日期</label>
            <input type="date" class="form-control" name="should_return_date" id="should_return_date" required
                   placeholder="请选择应还日期"
                   value="<?= $lend['should_return_date'] ?>"
                <?= !empty($lend['return_at']) ? 'disabled' : '' ?>
                   maxlength="20">
        </div>
        <div class="mb-3">
            <label for="remark" class="form-label">备注</label>
            <textarea class="form-control" name="remark" id="remark"><?= $lend['remark'] ?></textarea>
        </div>
        <div class="text-start">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
<?php require_once __DIR__ . '/../public/footer.php' ?>