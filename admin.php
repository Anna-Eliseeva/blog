<?php
if ( !$_SESSION['admin'] ) header('location: /');
include 'includes/header.php';

if ( $_GET['fnc'] === 'add_art' ) { ?>
    <h1>Добавление статьи</h1>
    <form action="/admin.php?fnc=add_art" method="post">
        <?php
        if ($_POST['add_art']) {
            mysqli_query($db_connect, "INSERT INTO `article` (`author`, `title`, `text`, `date`) VALUES ('$_POST[author]', '$_POST[title]', '$_POST[text]', NOW())");
            header('location: /');
        } ?>
        <p><input type="text" class="input" name="author" placeholder="Автор" value="<?= $_SESSION['login']; ?>"></p>
        <p><input type="text" class="input" name="title" placeholder="Заголовок"></p>
        <p><textarea name="text" style="max-width: 100%;font-size: 18px;" cols="30" rows="10" placeholder="Текст статьи"></textarea></p>
        <p><input type="submit" name="add_art" class="button"></p>
    </form>
<?php }
elseif ( $_GET['fnc'] === 're_art' AND !$_GET['id'] ) {
    $query = mysqli_query($db_connect, "SELECT `id, author, title, text, date` FROM `article` ORDER BY `id` DESC");
    $row = mysqli_num_rows($query);
    if ( !$row ) echo 'статьей не найдено';
    else {
        while ( $art = mysqli_fetch_assoc($query) ) { ?>
            <hr><article>
                <p>Автор: <?=$art['author']?></p>
                <span style="float: right;"><a style="color: #000;border-bottom: 1px solid #000;" href="/admin.php?fnc=re_art&id=<?=$art['id']?>">Редактировать</a></span>
                <p>Заголовок: <?=$art['title']?></p>
                <p>Текст: <?=$art['text']?></p>
                <p>Дата опубликования: <?=$art['date']?></p>
            </article>
        <?php }
    }
} elseif ($_GET['fnc'] === 're_art' AND $_GET['id']) { ?>
    <h1>Редактирование статьи</h1>
    <form action="/admin.php?fnc=re_art&id=<?=$_GET['id']?>" method="post">
        <?php

        $art = mysqli_fetch_assoc(mysqli_query($db_connect, "SELECT `id, author, title, text, date` FROM `article` WHERE `id` = {$_GET['id']}"));

        if ($_POST['re_art']) {
            $art = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id, author, title, text, date` FROM `article` WHERE `id` = {$_GET['id']}"));
            if ($_POST['remove_art']) {
                mysqli_query($connect, "DELETE FROM `article` WHERE `id` = {$_GET['id']}");
            } else {
                mysqli_query($connect, "UPDATE `article` SET  `author` =  '{$_POST['author']}',`title` = '{$_POST['title']}', `text` = '{$_POST['text']}' WHERE `id` = {$art['id']}");
            }

            header('location: /');
        }
        ?>
        <p><input type="text" class="input" name="author" placeholder="Автор" value="<?=$art['author']?>"></p>
        <p><input type="text" class="input" value="<?=$art['title']?>" name="title" placeholder="Заголовок"></p>
        <p><textarea name="text" style="max-width: 100%;font-size: 18px;" cols="30" rows="10" placeholder="Текст статьи">
				<?=$art['text']?>
			</textarea></p>
        <p><input type="submit" name="re_art" class="button">
            <span><input name="remove_art" value="remove" type="checkbox">Удалить статью</span></p>
    </form>
<?php }
include 'includes/footer.php';?>