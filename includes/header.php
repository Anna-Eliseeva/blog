<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <title>Мой блог</title>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <?php if (array_key_exists('admin', $_SESSION)) { ?>
            <div id="left">
                <a class="left" href="#">Админ Панель</a>
                <div class="hide">
                    <a href="/admin.php?fnc=add_art">Добавить статью</a>
                    <a href="/admin.php?fnc=re_art">Редактировать статью</a>
                </div>
            </div>
        <?php } ?>
        <div id="right">
            <?php if (!array_key_exists('id', $_SESSION)) { ?>
                <a href="/user.php?page=auth">Войти</a>
                <a href="/user.php?page=register">Регистрация</a>
            <?php } elseif (array_key_exists('id', $_SESSION)) { ?>
                <a href="/user.php?page=logout">Выход</a>
                <a href="/user.php?page=profile">Профиль</a>
            <?php } ?>
            <a href="#">Обо мне</a>
            <a href="#">Новости</a>
        </div>
        <div class="clear"></div>
    </div>
    <div id="content">