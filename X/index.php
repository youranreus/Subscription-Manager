<?php
header('Content-Type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin:*');
require 'main.class.php';
$X = new main();
if(isset($_GET['action'])){
    call_user_func(array($X, $_GET['action']));
}else{
    call_user_func(array($X, 'hello'));
}



