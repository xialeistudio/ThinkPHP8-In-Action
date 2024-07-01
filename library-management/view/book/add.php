<?php require_once __DIR__ . '/../public/header.php' ?>
    <form method="post" action="<?= url('book/do_add') ?>" class="col-4 mt-2">
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" id="isbn" required placeholder="请输入ISBN">
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">标题</label>
            <input type="text" class="form-control" name="title" id="title" required placeholder="请输入标题">
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">作者</label>
            <input type="text" class="form-control" name="author" id="author" required placeholder="请输入作者">
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">出版社</label>
            <input type="text" class="form-control" name="publisher" id="publisher" required placeholder="请输入出版社">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">价格</label>
            <input type="text" class="form-control" name="price" id="price" required placeholder="请输入书籍价格（元，支持两位小数）">
        </div>
        <div class="text-start">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
<?php require_once __DIR__ . '/../public/footer.php' ?>