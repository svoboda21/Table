<?php
    define('DB_DRIVER', 'mysql');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'BD');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    try {
        $connect_str = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
        $db = new PDO($connect_str, DB_USER, DB_PASS);
        $error_array = $db->errorInfo();
        $_SESSION['db']=$db;
        if ($db->errorCode() != 0000)
            echo "SQL " . $error_array[2] . '<br />';
        $error_array = $db->errorInfo();
        if ($db->errorCode() != 0000)
            echo "SQL: " . $error_array[2] . '<br /><br />';
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    if (!empty($_GET["table"])&&!empty($_GET["save"])) {
        $tablename=$_GET["table"];
        $table =$db->exec ("CREATE TABLE `$tablename` (
        `id` int(9) NOT NULL auto_increment,
        `name` varchar(15) NULL,
        `id_name` int(9) NULL,
        PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8");
        echo "Таблица $tablename добавлена";
    }
    if (!empty($_GET["action"])){
        header("Location: tablelist.php");
    }
    ?>
  <!DOCTYPE html>
  <html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Создание таблицы</title>
  </head>
  <body>
  <table>
    <td>
  <form method="GET">
    <br>
    <input type="text" name="table" placeholder="Название таблицы" value="" />
    <br>
    <input type="submit" name="save" value="Создать таблицу" />
    <br>
  </form>
  <form method="GET">
    <br>
    <input type="submit" name="action" value="Страница с таблицами" />
    </td>
  </form>
  </table>
  </body>
  </html>