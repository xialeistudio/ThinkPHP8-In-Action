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
    <div class="m-auto mt-5 col-4">
        <h2 class="text-center">登录</h2>
        <form action="<?=url('/admin/do_login')?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">账号</label>
                <input type="text" class="form-control" name="username" id="username" required placeholder="请输入账号"
                       maxlength="20">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">密码</label>
                <input type="password" class="form-control" name="password" id="password" required placeholder="请输入密码"
                       maxlength="20">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">登录</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>