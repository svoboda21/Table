<?php
    session_start();
    $tablename=$_SESSION['table'];
    echo "Таблица: $tablename";
    define('DB_DRIVER','mysql');
    define('DB_HOST','localhost');
    define('DB_NAME','bd');
    define('DB_USER','root');
    define('DB_PASS','');
    try
    {
        $connect_str = DB_DRIVER . ':host='. DB_HOST . ';dbname=' . DB_NAME;
        $db = new PDO($connect_str,DB_USER,DB_PASS);
        $error_array = $db->errorInfo();
        if($db->errorCode() != 0000)
            echo "SQL :fffdf " . $error_array[2] . '<br />';
        $error_array = $db->errorInfo();
        if($db->errorCode() != 0000)
            echo "SQL: " . $error_array[2] . '<br /><br />';
    }
    catch(PDOException $e)
    {
        die("Error: ".$e->getMessage());
    }
    $result =$db->query("DESCRIBE `$tablename` ");
?>
  <!DOCTYPE html>
  <html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Изменение таблицы</title>
  </head>
  <body>
    <form method="GET">
      <br>
      <input type="submit" name="back" value="Назад"/>
      <br>
<?php
    if (!empty($_GET['back'])) {
        header("Location: tablelist.php");
    }
    while($row = $result->fetch()) {
        if ($row['Field']!='id') {
            ?>
            <br>
            <?php echo 'Поле: ' . $row['Field'] . ' Тип: ' . $row['Type']; ?>
            <input type="radio" name="q2" value="<?php echo $row['Field'] ?>">
            <input type="submit" name="save" value="Изменить поле"/>
            <br>
            <?php
        }
   }
    if (!empty($_GET['save'])&&!empty($_GET['q2'])) {
        $name = $_GET['q2'];
            if (!empty($_POST['change'])) {
               if (!empty($_POST['desc'])&&!empty($_POST['q1'])) {
                   if ($_POST['q1']==2){
                       $type='int(9)';
                   } else {
                       $type='varchar(15)';
                   }
                   $text=$_POST['desc'];
                   echo $text;
                   $change =$db->query("ALTER TABLE $tablename CHANGE $name $text $type");
                   header("Location: table.php");
               }
            }
            if (!empty($_POST['delete'])){
               $resultdelete =$db->query("ALTER TABLE $tablename DROP COLUMN $name ");
           header("Location: table.php");
       }
   ?>
    </form>
  <form method="POST">
    <input type="text" name="desc" value="<?php echo $name;?>"/>
    <label><input type="radio" name="q1" value="1">Varchar</label>
    <label><input type="radio" name="q1" value="2">Int</label>
    <input type="submit" name="change" value="Изменить"/>
    <input type="submit" name="delete" value="Удалить"/>
  </form>
<?php
  }
?>
  </form>
  </body>
  </html>
