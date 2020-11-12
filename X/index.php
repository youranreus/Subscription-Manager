<?php
header('Content-Type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin:*');
//截取链接&参数
$uri = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if(isset($_SERVER["QUERY_STRING"])){
    $params = $_SERVER["QUERY_STRING"];
}else{
    $params = "";
}
require 'main.class.php';
$X = new main();
if(isset($uri[2])){
    call_user_func_array(array($X, $uri[2]), array($params));
}else{
    call_user_func_array(array($X, 'hello'), array($params));
}



