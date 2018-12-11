<?php

/*В данном файле находятся подключения к базе данных*/

$db_connect = mysqli_connect('localhost', 'root', 'lancer52662699', 'blog_db');
if (!$db_connect) {
    exit('MySqlError');
}
