<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理员登录</title>
    <link rel="stylesheet" href="/static/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="/static/bootstrap/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <div class="alert alert-danger mt-4"><?= $msg ?></div>
    <?php if (empty($callback)): ?>
        <p><a class="btn btn-primary" href="<?= request()->header('referer') ?>">返回</a></p>
    <?php else: ?>
        <p><a class="btn btn-primary" href="<?= $callback ?>">返回</a></p>
    <?php endif ?>
</div>
</body>
</html>