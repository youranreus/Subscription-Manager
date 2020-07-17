<?php
session_start();
require_once ('../CONF/conf.class.php');
$conf = new conf();

if($_SESSION['log'] !== true){
    header("location:/index.php?msg=还没有登录哟");
}

?>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, width=device-width"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo $conf->Webname; ?></title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.bootcss.com/normalize/8.0.1/normalize.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/animate.css/3.7.0/animate.min.css" rel="stylesheet">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link href="../CSS/main.css" rel="stylesheet">
</head>
<body>
<?php
if (isset($_GET["msg"])) {
    echo "<script>toastr.info('".$_GET["msg"]."');</script>";
}
?>
