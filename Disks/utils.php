<?php
function die_beautiful($code, $result, $location = null, $break = 2000)
{
    http_response_code($code);

    echo "<h1>{$result}</h1>";

    if (!is_null($location)) {
        echo "<script> if ('{$location}'){
        setTimeout(() => {window.location.replace('{$location}'); }, {$break});
    }</script>";
    }

    exit();
}

function response_json($code, $result)
{
    http_response_code($code);
    header('Content-type: application/json');
    echo json_encode($result);
    exit();
}