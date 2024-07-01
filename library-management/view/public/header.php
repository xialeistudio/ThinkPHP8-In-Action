<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '图书管理系统' ?></title>
    <link rel="stylesheet" href="/static/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="/static/bootstrap/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/">图书管理系统</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= url('/') ?>">书籍管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= url('/lend/index') ?>">借阅管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= url('/user/index') ?>">读者管理</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= url('admin/changepwd') ?>">修改密码</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('admin/logout') ?>">退出登录</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
