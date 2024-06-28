<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '多人博客' ?></title>
    <link rel="stylesheet" href="/static/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <script src="/static/bootstrap/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/">多人博客</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= url('category/index') ?>">分类列表</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (!empty(session('user'))): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            欢迎, <?=session('user')['username']?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?=url('/user')?>">个人中心</a></li>
                            <li><a class="dropdown-item" href="<?=url('/user/change_password')?>">修改密码</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('user/logout') ?>">退出登录</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('user/signin') ?>">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('user/signup') ?>">注册</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
