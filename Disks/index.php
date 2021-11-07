<?php //подключение к БД
session_start();
$host = '127.0.0.1'; //имя хоста, на локальном компьютере это localhost
$user = 'slave'; //имя пользователя, по умолчанию это root, но у меня slave
$password = 'megaslave'; //пароль, по умолчанию пустой, но у меня megaslave
$db_name = 'coursework'; //имя базы данных
$db = mysqli_connect($host, $user, $password, $db_name) or die('No db connection'); //подключение по параметрам выше или вывод ошибки
mysqli_query($db, "SET NAMES 'utf8'");//кодировка для подключение для всех языков

require_once __DIR__ . '/utils.php';

// логинимся

if (isset($_SESSION['user']))
    die_beautiful(307, 'Redirecting...', 'search.php', 0);

if (isset($_POST['type'])) {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        die_beautiful(400, 'Invalid login or password', 'index.php');
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        die_beautiful(400, 'Invalid login or password', 'index.php');
    }
    if (!preg_match('/^[A-Za-z0-9]+$/', $_POST['username'])) {
        die_beautiful(400, 'Invalid login or password', 'index.php');
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $db->query("SELECT * FROM users WHERE login='$username';");

    if ($query === false)
        die_beautiful(400, 'Invalid login or password', 'index.php');

    $query = $query->fetch_assoc();


    if ($_POST['type'] === 'login') {
        if (!isset($query['password']))
            die_beautiful(400, 'Invalid login or password', 'index.php');

        if ($query['password'] === md5($password)) {
            $_SESSION['user'] = $query;
            die_beautiful(200, 'Ok', 'search.php', 0);
        } else
            die_beautiful(400, 'Invalid login or password', 'index.php');
    } elseif ($_POST['type'] === 'register') {
        if (!empty($query['login']))
            die_beautiful(400, 'User already exists', 'index.php');

        if (strlen($username) < 3)
            die_beautiful(400, 'Too short login', 'index.php');

        if (strlen($password) < 5)
            die_beautiful(400, 'Too short password', 'index.php');

        $hashed_password = md5($password);

        $db->query("INSERT INTO users (login, password) values ('$username', '$hashed_password');");
        $db->commit();

        die_beautiful(200, 'Ok', 'index.php', 0);

    }
}
?>

<!doctype html>
<html>
<head>
    <title>Вход</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #17a2b8 url("bc.jpg");
            height: 100vh;
        }

        .login-box {
            margin-top: 120px;
            max-width: 600px;
            height: 320px;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }

        .register-box {
            margin-top: 120px;
            max-width: 600px;
            height: 400px;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
        }


        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
        }

        #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -65px;
        }
    </style>
</head>
<body>
<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="login-box col-md-12">
                    <form id="login-form" class="form" action="" method="post">
                        <h3 class="text-center text-info">Авторизация</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Логин:</label><br>
                            <input type="text" name="username" id="username" class="form-control" minlength="3">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Пароль:</label><br>
                            <input type="password" name="password" id="password" class="form-control" minlength="5">
                        </div>

                        <div class="form-group" hidden="hidden" id="password-retype-block">
                            <label for="password-retype" class="text-info">Повторите пароль:</label><br>
                            <input type="password" name="password_retype" id="password-retype" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit-btn" class="btn btn-info btn-md"
                                   value="Войти">
                        </div>
                        <input type="hidden" name="type" value="login" id="task-type">
                        <div id="register-link" class="text-right">
                            <input type="button" id="register-button" class="text-info"
                                   style="outline: none; border: none; background: none; cursor: pointer"
                                   value="Регистрация"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(document).ready(() => {
        $('#register-button').click(() => signUp())
    })

    function signUp() {
        $('#password-retype-block').removeAttr('hidden');
        $('#register-button').val('Логин');
        $('#login-box').removeClass('login-box');
        $('#login-box').addClass('register-box');
        $('#task-type').val('register')
        $('#submit-btn').val('Зарегестрироваться')
        $('#register-button').unbind('click');
        $('#register-button').click(() => signIn())
    }

    function signIn() {
        $('#password-retype-block').attr('hidden', 'hidden');
        $('#register-button').val('Регистрация');
        $('#login-box').removeClass('register-box');
        $('#login-box').addClass('login-box');
        $('#task-type').val('login')
        $('#submit-btn').val('Войти')
        $('#register-button').unbind('click');
        $('#register-button').click(() => signUp())
    }
</script>
