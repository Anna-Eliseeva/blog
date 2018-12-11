<?php

session_start();

require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/header.php';

if ($_GET['page'] === 'auth') {
    if (array_key_exists('id', $_SESSION)) {
        header('location: /');
    } ?>
    <h1>Авторизация</h1>
    <form action="/user.php?page=auth" method="post">
        <?php if (array_key_exists('do_login', $_POST)) {
            $_POST['password'] = md5($_POST['password']);
            $query = "SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' AND `password` = '{$_POST['password']}'";
            $row = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($row)) {
                $ass = mysqli_fetch_assoc($row);
                foreach ($ass as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                header('location: /user.php?page=profile');
            } else {
                echo '<b>Логин или пароль введены неправильно</b>';
            }
        } ?>
        <p><input class="input" name="login" type="text" placeholder="Логин"></p>
        <p><input class="input" name="password" type="password" placeholder="Пароль"></p>
        <p><input class="button" name="do_login" type="submit" value="Войти"></p>
    </form>
<?php } elseif ($_GET['page'] === 'register') {
    if (array_key_exists('id', $_SESSION)) {
        header('location: /');
    } ?>
    <h1>Регистрация</h1>
    <form action="/user.php?page=register" method="post">
        <?php
        if (array_key_exists('do_register', $_POST)) {
            $row = mysqli_query($db_connect, "SELECT * FROM `users` WHERE `login` = '{$_POST['login']}'");
            if (mysqli_num_rows($row)) {
                echo '<b>Логин уже занят</b>';
            } elseif ($_POST['login'] != '' && $_POST['password'] != '' && $_POST['password'] === $_POST['password2']) {
                $_POST['password'] = md5($_POST['password']);
                mysqli_query($db_connect, "INSERT INTO `users` (`login`, `password`, `admin`) VALUES ('{$_POST['login']}', '{$_POST['password']}', '0')");
                echo "Успешная регистрация";
                header('refresh: 2; url=/');
            } else {
                echo "Вы где-то ошиблись, проверьте себя";
            }
        } ?>
        <p><input class="input" name="login" type="text" placeholder="Логин"></p>
        <p><input class="input" name="password" type="password" placeholder="Пароль"></p>
        <p><input class="input" name="password2" type="password" placeholder="Подтверждение пароля"></p>
        <p><input class="button" name="do_register" type="submit" value="Зарегистрироваться"></p>
    </form>
<?php } elseif ($_GET['page'] === 'profile') {
    if (!$_SESSION['id']) {
        header('location: /');
    } ?>
    <h2><b>Привет, <?= $_SESSION['login']; ?></b></h2>
<?php } elseif ($_GET['page'] === 'logout') {
    session_destroy();
    header('location: /');
}

require_once __DIR__ . '/includes/header.php';
