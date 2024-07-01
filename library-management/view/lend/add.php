<?php require_once __DIR__ . '/../public/header.php' ?>
    <form method="post" action="<?= url('lend/do_add') ?>" class="col-4 mt-2">
        <div class="mb-3">
            <label for="book_id" class="form-label">书籍</label>
            <select name="book_id" id="book_id" class="form-control">
                <?php foreach ($books as $book): ?>
                    <option value="<?= $book['book_id'] ?>"><?= $book['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">读者</label>
            <select name="user_id" id="user_id" class="form-control">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['user_id'] ?>"><?= $user['realname'] ?>/<?= $user['phone'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="lending_date" class="form-label">借出日期</label>
            <input type="date" class="form-control" name="lending_date" id="lending_date" required
                   placeholder="请选择借出日期"
                   maxlength="20">
        </div>
        <div class="mb-3">
            <label for="should_return_date" class="form-label">应还日期</label>
            <input type="date" class="form-control" name="should_return_date" id="should_return_date" required
                   placeholder="请选择应还日期"
                   maxlength="20">
        </div>
        <div class="mb-3">
            <label for="remark" class="form-label">备注</label>
            <textarea class="form-control" name="remark" id="remark"></textarea>
        </div>
        <div class="text-start">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
<?php require_once __DIR__ . '/../public/footer.php' ?>