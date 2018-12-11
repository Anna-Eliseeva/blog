<?php

session_start();

require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="block">
    <?php
    $query = mysqli_query($db_connect, 'SELECT * FROM `article` ORDER BY `id` DESC');
    $row = mysqli_num_rows($query);

    /*Делаем проверку на приход статей*/
    if (!$row) {
        echo 'статьей не найдено';
    } else {
        while ($art = mysqli_fetch_assoc($query)): ?>
            <hr><article>
                <p>Автор: <?= $art['author']; ?></p>
                <p>Заголовок: <?= $art['title']; ?></p>
                <p>Текст: <?= $art['text']; ?></p>
                <p>Дата опубликования: <?= $art['date']; ?></p>
            </article>
        <?php endwhile; ?>
    <?php } ?>
</div>
