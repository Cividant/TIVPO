<html >
<head>
    <title>Вход</title>
    <meta charset="UTF-8" />
    <style>
        body {
            background: url("bc.jpg");
        }
        .main {
            left: 40%;
            top: 40%;
            position: absolute;
        }
        .reg {
           position:relative;
            width: 30vh;
            height: 10vh;
            background-color: rgb(169, 169, 169);
            z-index: 6;
            border: 1vh rgba(0,0,0,0.3);
            border-style:inset;
            border-radius: 1vh;
        }
        .dopblock {
            position: relative;
            width: 15vh;
            height: 20vh;
            border: 1vh rgba(0,0,0,0.3);
            margin-left: 15vh;
            z-index: 7;
            border-style: inset;
            border-radius: 1vh;
            background-color: rgb(169, 169, 169);
            margin-top:-17vh;
        }
        .mainblock {
            position: absolute;
            width: 28vh;
            height: 10vh;
            z-index: 8;
            margin-top: -16vh;
            background-color: rgb(169, 169, 169);
            margin-left: 1vh;
        }
        h2{
            text-align:center;
           font-size: 1.5em;
           margin-top:auto;
        }
        h3 {
            text-align: right;
            margin-top: auto;
        }
        .but1, .but2 {
            width: 15vh;
            height: 4vh;
            font-size: 1.2vw;
            color: darkgrey;
            z-index: 100;
            position: absolute;
            margin-top: -4.5vh;
            border-radius: 0 1vh 0 1vh ;
        }
        .but2 {
            margin-top: 12.5vh;
            border-radius: 1vh 0 1vh 0;
        }
        .send{
            position:absolute;
            margin-left:17vh;
        }
        .send1{
            position: absolute;
            margin-left: 17vh;
            margin-top:3vh;
        }
      input{
          width:10vh;
          height:3vh;
      }
    </style>
</head>
<body onload="log()">
    <div class="main">
        <input type="button" class="but1" value="Регистрация" onclick="reg()" /><!--при нажитии кнопки выводятся соответстующие поля-->
        <input type="button" class="but2" value="Вход" onclick="log()" />
        <div class="reg"></div>
        <div class="dopblock">
            <h2>Disk planet</h2>
        </div>
        <form  method="GET">
            <div class="mainblock" id="reg">
                    <h3>Логин:  <input name="login"/><br />Пароль:  <input name="pass"/><br />Повтор Пароля:  <input name="pass2" /></h3><!--форма для ввода данных-->
                    <input type="submit" class="send" value="Зарегистрироваться" name="reg" /><!--форма для отправки данных-->
            </div>
                <div class="mainblock" id="log">
                    <h3>Логин:  <input name="loginl" /><br />Пароль:  <input name="passl"/></h3>
                    <input type="submit" class="send1" value="Войти"name="log" />
            </div>
</form>
        </div>
</body>
</html>
<script>
    function log() {
        (document.getElementById("reg").style.display = "none");//при нажитии кнопки выводятся соответстующие поля
        (document.getElementById("log").style.display = "block");
    }
    function reg() {
        (document.getElementById("reg").style.display = "block");
        (document.getElementById("log").style.display = "none");
    }
</script>
<?php //подключение к БД
$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
$user = 'j96535km_sait'; //имя пользователя, по умолчанию это root
$password = 'QF6MMxd&'; //пароль, по умолчанию пустой
$db_name = 'j96535km_sait'; //имя базы данных
$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link)); //подключение по параметрам выше или вывод ошибки
mysqli_query($link, "SET NAMES 'utf8'");//кодировка для подключение для всех языков

//логинимся
if (isset($_GET['loginl'])) { $login = $_GET['loginl']; if ($login == '') { unset($login);} }//получение данных с поля логина
if (isset($_GET['log'])){ //срабатывает по нажатию залогиниться
$password = $_GET['passl'];
$query = "SELECT*FROM users WHERE name='$login'";//выбор из таблицы пользователей из бд
$result = mysqli_query ($link , $query);
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) {//получает данные с бд
 $pass1 =  $elem['password'] ;//получение пароля с бд
 $allvl=   $elem['allowment'] ;//получение  с бд
} 
if($pass1 != $password){//Проверка совпадает ли введённый пароль с паролем в базе данных
echo "Неверный пароль";
}
if(empty($password)){//не пустое ли поле пороля
echo "введите пароль";
}
else if($pass1 == $password){//если пароль с бд и введенный совпадают
 echo "<script>alert(\"Вы успешно вошли\");</script>"; 
 $allvlS=$allvl.'LVL';
 echo "<script>window.location.href='./serch.php?id=$allvlS'</script>";//направляет на основную страницу
}

//регистрируемся
}
if (isset($_GET['login'])) { $login = $_GET['login']; if ($login == '') { unset($login);} }//получение логина для регистрации
if (isset($_GET['reg'])){ //выполнение при нажатии кнопки зарег
$password = $_GET['pass'];
$password1 = $_GET['pass2'];
//проверка на уже зарегестрированного пользователя
$query = "SELECT*FROM users WHERE name='$login'";//выбрать таблицу users
$result = mysqli_query ($link , $query);
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) { 
 $pass1 =  $elem['password'] ; 
} 
if(!empty($pass1)){
echo "<script>alert(\"Пользователь с данным логином уже зарегистрирован.\");</script>"; 
exit();
}

if($password1 != $password){
echo "Пароли не совпадают";
}
elseif ($password1 == $password){
 if (mb_strlen($password) < 4)
 exit("Пароль должен быть длинее 4 символов.");
 mysqli_query($link, "INSERT INTO users SET name='$login', password='$password', allowment='0'") or die(mysqli_error($link)); //запись в бд
 echo "<script>alert(\"Регистрация прошла успешно!\");</script>"; 
 
}
}
?>