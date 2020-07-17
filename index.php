<?php
/**
 *订阅管理
 *
 * @author      季悠然<youranreus@qq.com>
 * @version     0.1
 */

require_once ('CONF/conf.class.php');
$conf = new conf();

if(isset($_POST["pwd"])){
    if($_POST["pwd"] == $conf->pwd){

        session_start();
        $_SESSION['log'] = true;
        header('location:/panel?msg=登陆成功');
    }else{
        header('location:index.php?msg=密码错误');
    }
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

        <link href="CSS/main.css" rel="stylesheet">
    </head>
    <body>
        <div id="main">
            <h2><?php echo $conf->Webname; ?></h2>
            <p>看看我的小鸡们怎么样了...</p>



            <form action="" method="post">
                <input type="password" name="pwd" placeholder="密钥">
            </form>

        </div>
    </body>
    <?php
    if (isset($_GET["msg"])) {
        echo "<script>toastr.info('".$_GET["msg"]."');</script>";
    }
    ?>
</html>
