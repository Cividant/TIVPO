<?php
session_start();
$host = '127.0.0.1'; //имя хоста, на локальном компьютере это localhost
$user = 'slave'; //имя пользователя, по умолчанию это root, но у меня slave
$password = 'megaslave'; //пароль, по умолчанию пустой, но у меня megaslave
$db_name = 'coursework'; //имя базы данных
$db = mysqli_connect($host, $user, $password, $db_name) or die('No db connection'); //подключение по параметрам выше или вывод ошибки
mysqli_query($db, "SET NAMES 'utf8'");//кодировка для подключение для всех языков

require_once __DIR__ . '/utils.php';

if (!isset($_SESSION['user']))
    die_beautiful(401, 'Unauthorized', 'index.php');

if (isset($_POST['state']) && isset($_POST['field']) && isset($_POST['value'])) {
    $state = $_POST['state'];
    $field = $_POST['field'];
    $value = $db->real_escape_string(strtolower($_POST['value']));
    $sql = '';
    $error = '';

    if ($state === 'contains') {
        if ($field === 'anything') {
            $sql = "SELECT * FROM disks where 
                          name like '%$value%' or 
                          type like '%$value%' or 
                          CONVERT(memory,char) like '%$value%' or 
                          CONVERT(rotation, char) like '%$value%' or
                          interface like '%$value%' or
                          CONVERT(format, char) like '%$value%' or
                          CONVERT(price, char) like '%$value%'";
        } elseif ($field === 'name') {
            $sql = "SELECT * FROM disks where name like '%$value%'";
        } elseif ($field === 'type') {
            $sql = "SELECT * FROM disks where type like '%$value%'";
        } elseif ($field === 'memory') {
            $sql = "SELECT * FROM disks where CONVERT(memory,char) like '%$value%'";
        } elseif ($field === 'rotation') {
            $sql = "SELECT * FROM disks where CONVERT(rotation, char)  like '%$value%'";
        } elseif ($field === 'interface') {
            $sql = "SELECT * FROM disks where interface like '%$value%'";
        } elseif ($field === 'format') {
            $sql = "SELECT * FROM disks where CONVERT(format, char) like '%$value%'";
        }
    } elseif ($state === 'equal') {
        if ($field === 'anything') {
            $sql = "SELECT * FROM disks where 
                          name = '$value' or 
                          type = '$value' or 
                          CONVERT(memory,char) = '$value' or 
                          CONVERT(rotation, char) = '$value' or
                          interface = '$value' or
                          CONVERT(format, char) = '$value' or
                          CONVERT(price, char) = '$value'";
        } elseif ($field === 'name') {
            $sql = "SELECT * FROM disks where name = '$value'";
        } elseif ($field === 'type') {
            $sql = "SELECT * FROM disks where type = '$value'";
        } elseif ($field === 'memory') {
            $sql = "SELECT * FROM disks where CONVERT(memory,char) = '$value'";
        } elseif ($field === 'rotation') {
            $sql = "SELECT * FROM disks where CONVERT(rotation, char)  = '$value'";
        } elseif ($field === 'interface') {
            $sql = "SELECT * FROM disks where interface = '$value'";
        } elseif ($field === 'format') {
            $sql = "SELECT * FROM disks where CONVERT(format, char) = '$value'";
        }
    } elseif ($state === 'greater_than') {
        if ($field === 'anything') {
            $error = 'Can\'t use Anything and Greater than in pair';
        } elseif ($field === 'name') {
            $error = 'Can\'t use name and Greater than in pair';
        } elseif ($field === 'type') {
            $error = 'Can\'t use type and Greater than in pair';
        } elseif ($field === 'memory') {
            $sql = "SELECT * FROM disks where memory > $value";
        } elseif ($field === 'rotation') {
            $sql = "SELECT * FROM disks where rotation > $value";
        } elseif ($field === 'interface') {
            $error = 'Can\'t use interface and Greater than in pair';
        } elseif ($field === 'format') {
            $sql = "SELECT * FROM disks where format > $value";
        }
    } elseif ($state === 'less_than') {
        if ($field === 'anything') {
            $error = 'Can\'t use Anything and Less than in pair';
        } elseif ($field === 'name') {
            $error = 'Can\'t use name and Less than in pair';
        } elseif ($field === 'type') {
            $error = 'Can\'t use type and Less than in pair';
        } elseif ($field === 'memory') {
            $sql = "SELECT * FROM disks where memory < $value";
        } elseif ($field === 'rotation') {
            $sql = "SELECT * FROM disks where rotation < $value";
        } elseif ($field === 'interface') {
            $error = 'Can\'t use interface and Less than in pair';
        } elseif ($field === 'format') {
            $sql = "SELECT * FROM disks where format < $value";
        }
    }

    if (!empty($error)) {
        response_json(400, array('error' => $error));
    }

    $result = $db->query($sql);

    if ($result === false)
        response_json(404, array('error' => 'Nothing found'));


    if (empty($result))
        response_json(404, array('error' => 'Nothing found'));

    $tmp = array();
    while ($_ = $result->fetch_array(MYSQLI_ASSOC))
        array_push($tmp, $_);

    response_json(200, array('response' => $tmp));

}

?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" type="text/css" href="style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
          integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Информационно-справочная система</title>
    <script>
        $(document).ready(function (e) {
            $('#addBtn').click(() => {
                window.location.replace('addDisk.php')
            })
            $('#field-menu').find('a').click(function (e) {
                e.preventDefault();
                var param = $(this).attr("href").replace("#", "");
                var concept = $(this).text();
                $('#search_concept-field').text(concept);
                $('#search-field').val(param);
            });

            $('#state-menu').find('a').click(function (e) {
                e.preventDefault();
                var param = $(this).attr("href").replace("#", "");
                var concept = $(this).text();
                $('#search_concept-state').text(concept);
                $('#search-state').val(param);
            });

            $('#submit_btn').click(() => {
                $('#table-obj > tbody').empty()
                let search_field = $('#search-field').val()
                let search_state = $('#search-state').val()
                let search_value = $('#search-value').val()

                let params = new URLSearchParams();
                params.set('field', search_field);
                params.set('state', search_state);
                params.set('value', search_value);

                fetch('search.php', {
                    method: 'POST',
                    body: params
                }).then(x => {
                    x.json().then((res) => {
                        if (x.status !== 200) {
                            toastr.error(res.error)
                        } else {
                            $('#main').animate({marginTop: '2vh', paddingBottom: '1vh'}, 1000);

                            res.response.forEach(function (item, i, arr) {
                                $('#table-obj > tbody:last-child').append('<tr><th scope="row">' + (i + 1) + '</th><td>' + item.name + '</td><td>' + item.type + '</td><td>' + item.memory + '</td><td>' + item.rotation + '</td><td>' + item.interface + '</td><td>' + item.format + '</td><td>' + item.price + '</td></tr>');
                            })

                            $('#mtable').removeAttr('hidden');

                        }
                    });

                })
            })
        });
    </script>
    <style>
        .main {
            margin-top: 50vh;
        }

        .mtable {
            width: 100%;
        }

        .mtable table {
            width: 100%;
        }

        #addBtn{
            background-color: greenyellow;
        }

    </style>
</head>
<body>
<div class="main" id="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">

                <div class="input-group">
                    <?PHP
                    if ($_SESSION['user']['role'] === '1')
                    echo '
                    <div class="input-group-btn search-panel">
                        <button id="addBtn" type="button" class="btn btn-default dropdown-toggle-field">
                            <span>+</span>
                        </button>

                    </div>';

                    ?>

                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle-field" data-toggle="dropdown">
                            <span id="search_concept-field">Anything</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="field-menu" role="menu">
                            <li><a href="#anything">Anything</a></li>
                            <li class="divider"></li>
                            <li><a href="#name">Name</a></li>
                            <li><a href="#type">Type</a></li>
                            <li><a href="#memory">Memory</a></li>
                            <li><a href="#rotation">Rotation</a></li>
                            <li><a href="#interface">Interface</a></li>
                            <li><a href="#format">Format</a></li>
                        </ul>
                    </div>
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle-field" data-toggle="dropdown">
                            <span id="search_concept-state">Contains</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="state-menu" role="menu">
                            <li><a href="#contains">Contains</a></li>
                            <li><a href="#equal">Equal</a></li>
                            <li><a href="#greater_than">Greater than </a></li>
                            <li><a href="#less_than">Less than </a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="search-field" value="anything" id="search-field">
                    <input type="hidden" name="search-state" value="contains" id="search-state">
                    <input type="text" class="form-control" name="x" placeholder="Search term..." id="search-value">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="submit_btn"><span
                                class="glyphicon glyphicon-search"></span></button>
                </span>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="mtable" id="mtable" hidden="hidden">
    <table class="table" id="table-obj">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Memory</th>
            <th scope="col">Rotation</th>
            <th scope="col">Interface</th>
            <th scope="col">Format</th>
            <th scope="col">Price</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>

</body>
</html>