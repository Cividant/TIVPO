<?php
session_start();
$host = '127.0.0.1'; // имя хоста, на локальном компьютере это localhost
$user = 'slave'; // имя пользователя, по умолчанию это root, но у меня slave
$password = 'megaslave'; // пароль, по умолчанию пустой, но у меня megaslave
$db_name = 'coursework'; // имя базы данных
$db = mysqli_connect($host, $user, $password, $db_name) or die('No db connection'); // подключение по параметрам выше или вывод ошибки
mysqli_query($db, "SET NAMES 'utf8'"); // кодировка для подключение для всех языков

require_once __DIR__ . '/utils.php';

if (!isset($_SESSION['user']))
    die_beautiful(401, 'Unauthorized', 'index.php');
if ($_SESSION['user']['role'] !== '1')
    die_beautiful(403, 'Forbidden', 'search.php');

if (isset($_POST['submit'])) {
    if (empty($_POST['name']))
        die_beautiful(400, 'Name can\'t be empty', 'addDisk.php');

    $name = $_POST['name'];
    $type = $_POST['type'] or null;
    $memory = $_POST['memory'] or null;
    $rotation = $_POST['rotation'] or null;
    $interface = $_POST['interface'] or null;
    $format = $_POST['format'] or null;
    $price = $_POST['price'] or null;

    $db->query("INSERT INTO disks (name, type, memory, rotation, interface, format, price) values ('$name', '$type', $memory, $rotation, '$interface', '$format', $price)");
    $db->commit();

    die_beautiful(200, 'Disk added', 'index.php');

}
?>
<!doctype html>
<html>
<head>
    <title>Добавить диск</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .main {
            display: flex;
            flex-flow: column nowrap;
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div>
    <form class="main" action="" method="post">
        <input name="name" placeholder="Name" type="text"/>
        <input name="type" placeholder="Type" type="text"/>
        <input name="memory" placeholder="Memory" type="number"/>
        <input name="rotation" placeholder="Rotation (rpm)" type="number"/>
        <input name="interface" placeholder="Interface" type="text"/>
        <input name="format" placeholder="Format" type="text"/>
        <input name="price" placeholder="Price" type="number"/>
        <input name="submit" type="submit" value="Добавить"/>
    </form>
</body>
</html>
