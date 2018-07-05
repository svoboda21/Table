  <!DOCTYPE html>
  <html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Список таблиц</title>
  </head>
  <body>
  <h2>Список таблиц в базе данных</h2>
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
    $tablelist =$db->query("SHOW TABLES");
    if (!empty($_GET['save'])&&!empty($_GET['q1'])){
        session_start();
        $_SESSION['table']=$_GET['q1'];
        echo $_GET['q1'];
        header("Location: table.php");

    }

    while($tablelist1 = $tablelist->fetch()) { ?>
        <form method="GET">
            <br>
            <input type="text" name="table" placeholder="<?php echo $tablelist1['Tables_in_bd'];?>" value="" />
            <label><input type="radio" name="q1" value="<?php echo $tablelist1['Tables_in_bd']?>"></label>
 <?php
    }
    ?>
            <br>
            <br>
            <input type="submit" name="save" value="Изменить" />
        </form>
  </body>
  </html>