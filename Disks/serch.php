
<meta charset="UTF-8" /> <!--кодировка-->
<?php 
$host = 'localhost'; //имя хоста, на локальном компьютере это localhost
$user = 'j96535km_sait'; //имя пользователя, по умолчанию это root
$password = 'QF6MMxd&'; //пароль, по умолчанию пустой
$db_name = 'j96535km_sait'; //имя базы данных
$link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link)); //подключение по параметрам выше или вывод ошибки
mysqli_query($link, "SET NAMES 'utf8'");//кодировка для подключение для всех языков

$label = 'id';//получения уровня доступа из index
if ( !empty( $_GET[ $label ]))//пустой ли доступ? пуст если не зарегался
{
  $lvl = $_GET[ $label ];//присвоение если было 0
}
if (empty( $lvl )){//проверяем уровень доступа
?>
<h1 text-align="center">Доступ запрещён. </h1><!--если пустая - доступ запрещен-->
<?php 
}
else{//если лвл не пустой то  выполнить все ниже
?>
<head>
<html lang="en" class="no-js">
<link rel="stylesheet" type="text/css" href="style.css" /> 
<script src="supervision.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <!--Адаптивность браузера-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>информационно справочная система</title>
</head>
<body > 
<div class="par" >
<div class="blockadd" id="adddisk"><!--блок добавления диска - по умолачнию скрыт-->
<form method="GET"><!--форма добавления диска-->
<input type="text"  name = "disk" placeholder="Название диска" size = "32%" > 
<input type="text"  name = "type" placeholder="тип диска" size = "32%">
<input type="text"  name = "howm" placeholder="объём"  size = "32%" > 
<input type="text"  name = "speed" placeholder="скорость вращения" size = "32%" > 
<input type="text"  name = "interface" placeholder="Интерфейс"size = "32%">
<input type="text"  name = "format" placeholder="формат" size = "32%"> 
<input type="text"  name = "costv" placeholder="цена" size = "32%" > 
<input type="text" class="hiden" name = "id"  value="1LVL">
<input id="addd"  type="submit"  name="addd"  value="Добавить" size = "32%"> 
</form>
</div>
<div class="imgb" id="imgb"> <!--Картинка -->
<img src="logo.png" class="imgc"  alt="Logo" id="gov"></img> <!--Логотип -->
</div>
<div class="midbl" id="block"> <!--Блок с поиском и кнопками-->


<!--Форма для строки поиска и ползунка цены-->
<form method="GET" oninput="level.value=pr.value"> <!--Для отправки данных php-->
<input type="text" class="mainserch"  name = "serch" size = "10%" maxlength = "15"> <!--Строка поиска-->
<input type="text" class="hiden" name = "id" id="why" value="1lvl"><!--каждый раз отправляет уровень допуска при выполнении поиска-->
<input type="text" id="goto" class="none"  name = "var"  maxlength = "2" value="30"> 
<input id="ser" class="but" type="submit"  name="ser"  value="поиск" onClick="dothis()" > </input> <!--Для отправки данных по нажатию кнопки-->

<script type="text/javascript">//скрипт по умолчанию
var ta = '<?php echo $lvl;?>';//передаем в js значения уровня доступа из php
document.getElementById('why').value =ta;//присваиваем полю значение уровня доступа
if(ta=='1LVL'){//если уровень доступа 1, то отображем блок добавления диска
	 (document.getElementById("adddisk").style.display = "block");
}
</script>
<!--"Кнопка" цены полностью-->
<div class="U"> 
<div class="B">
<input id="prise" name="pr"  type="range" min='1' max='100000' step='50' name="prise"  value='50000'  > </input> <!--Ползунок цены-->
<output for="prise" name="level">50000</output> <!--Значение цены на кнопке-->
</div>
</div>

</form> 


<div class="chose"> <!--Сами кнопки-->
<button class="butch" onClick="num(1)">отобразить все</button>
<button class="butch" onClick="num(2)">поиск по размеру</button>
<button class="butch" onClick="num(3)">поиск по имени</button>
<button class="butch" onClick="num(4)">поиск по типу</button>
</div>

<div class="showblock" id="all"> <!--Показать все диски-->


<?php //подключение к БД
if (isset($_GET['disk'])) { $named  = $_GET['disk']; if ($named  == '') { unset($named );} }//если в поле что то есть, то передаем значение переменной
if (isset($_GET['type'])) { $typed = $_GET['type']; if ($typed == '') { unset($typed);} }
if (isset($_GET['howm'])) { $memoryd = $_GET['howm']; if ($memoryd == '') { unset($memoryd);} }
if (isset($_GET['speed'])) { $rotationd = $_GET['speed']; if ($rotationd == '') { unset($rotationd);} }

if (isset($_GET['interface'])) { $interfaced = $_GET['interface']; if ($interfaced == '') { unset($interfaced);} }
if (isset($_GET['format'])) { $formatd = $_GET['format']; if ($formatd == '') { unset($formatd);} }
if (isset($_GET['costv'])) { $priced = $_GET['costv']; if ($priced == '') { unset($priced);} }

if (isset($_GET['addd'])) {//при нажатии кнопи добавить срабатывает функция
mysqli_query($link, "INSERT INTO disks SET name='$named', type='$typed',memory='$memoryd',rotation='$rotationd',interface='$interfaced',format='$formatd',price='$priced'") or die(mysqli_error($link));
echo "<script>alert('Диск добавлен успешно')</script>";
}

if (isset($_GET['ser'])) { //Если данные получены
$p = $_GET['var']; //не видимая переменная (вывод ничего если кнопка не нажата(по умолчанию 30))
$ser = $_GET['serch'];//отправляем данные в переменные
$pr=$_GET['pr'];
echo "<script>dothis()</script>";
}
if($p!=30){
//вывод пустой таблички
//заголовок пустой таблицы
?>	
<table width="100%"> <tr > <th>№</th><th  >Название </th><th >тип</th><th>объём</th> <th >скорость вращения</th> <th >интерфейс</th> <th >формат</th> <th >цена</th> 
<?php
}
if($p==30){ //если нажали еще раз поиск, то возврат в изначальное состояние
echo "<script>dothisback()</script>";
}

//Реализация кнопок
if($p==1){
$query = "SELECT * FROM disks WHERE id > 0"; //берем все диск из БД
$result = mysqli_query($link, $query) or die(mysqli_error($link)); 
$num=0;//переменная id
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) { //вывод только самих значений 
$num=$num+1; //для всех строк таблицы циклично выводим все столбцы из БД
$result .= '<tr>'; //что бы записывало в таблицу в столбик после каждого прохода цикла
$result .= '<td id="trig">' . $num . '</td>';
$result .= '<td id="trig">' . $elem['name'] . '</td>';
$result .= '<td>' . $elem['type'] . '</td>'; 
$result .= '<td>' . $elem['memory'] ." ГБ". '</td>'; 
$result .= '<td>' . $elem['rotation'] . '</td>'; 
$result .= '<td>' . $elem['interface'] . '</td>'; 
$result .= '<td>' . $elem['format'] . '</td>';
$result .= '<td>' . $elem['price'] ."₽". '</td>'; //вывод цены + "₽"
} 
echo $result; 
}

if($p==2){
$num=0;
$query = "SELECT * FROM disks WHERE ((memory LIKE '$ser')AND (price <'$pr'))"; //с помощью лайк сравниваем вводимое в поиск с тем что есть в БД
$result = mysqli_query($link, $query) or die(mysqli_error($link)); //подключение к БД и запись в нее значений
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) { 
$num=$num+1;
$result .= '<tr>'; 
$result .= '<td id="trig">' . $num . '</td>';
$result .= '<td id="trig">' . $elem['name'] . '</td>';
$result .= '<td>' . $elem['type'] . '</td>'; 
$result .= '<td>' . $elem['memory'] ." ГБ". '</td>'; 
$result .= '<td>' . $elem['rotation'] . '</td>'; 
$result .= '<td>' . $elem['interface'] . '</td>'; 
$result .= '<td>' . $elem['format'] . '</td>';
$result .= '<td>' . $elem['price'] ."₽". '</td>'; 
} 
echo $result; 
}

if($p==3){
$query = "SELECT * FROM disks WHERE ((name LIKE '$ser%') AND (price <'$pr'))"; 
$result = mysqli_query($link, $query) or die(mysqli_error($link));
$num=0;
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) { 
$result .= '<tr>'; 
$num=$num+1;
$result .= '<td id="trig">' . $num . '</td>';
$result .= '<td id="trig">' . $elem['name'] . '</td>';
$result .= '<td>' . $elem['type'] . '</td>'; 
$result .= '<td>' . $elem['memory'] ." ГБ". '</td>'; 
$result .= '<td>' . $elem['rotation'] . '</td>'; 
$result .= '<td>' . $elem['interface'] . '</td>'; 
$result .= '<td>' . $elem['format'] . '</td>';
$result .= '<td>' . $elem['price'] ."₽". '</td>'; 
} 
echo $result; 
}

if($p==4){
$query = "SELECT * FROM disks WHERE ((type LIKE '$ser%') AND (price <'$pr'))"; 
$result = mysqli_query($link, $query) or die(mysqli_error($link));
$num=0;
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row); $result = ''; foreach ($data as $elem) { 
$num=$num+1;
$result .= '<tr>'; 
$result .= '<td id="trig">' . $num . '</td>';
$result .= '<td id="trig">' . $elem['name'] . '</td>';
$result .= '<td>' . $elem['type'] . '</td>'; 
$result .= '<td>' . $elem['memory'] ." ГБ". '</td>'; 
$result .= '<td>' . $elem['rotation'] . '</td>'; 
$result .= '<td>' . $elem['interface'] . '</td>'; 
$result .= '<td>' . $elem['format'] . '</td>';
$result .= '<td>' . $elem['price'] ."₽". '</td>'; 
} 
echo $result; 
}
?>
</div>
</div>
</div>
</body>
</html>
<?php 
}
?>