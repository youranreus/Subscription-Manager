<?php


require_once('CONF/conf.class.php');
require_once('C/X.class.php');
require_once("C/Smtp.class.php");


$conf = new conf();
echo "启动邮件服务\n";
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);
echo "寻找即将过期小鸡\n";
$EndangerMachineID = $X->getEndangerMachine();
if(count($EndangerMachineID)==0){
  echo "无即将过期小鸡\n程序结束";
  exit();
}
echo "找到了".count($EndangerMachineID)."台即将过期小鸡，准备发信\n";

$mailcontent = "<h1>你有".count($EndangerMachineID)."台🐥将要过期，请到您的[订阅管理]查看</h1><br>";
$smtp = new Smtp($conf->SMTP_Adress,$conf->SMTP_Port,true,$conf->SMTP_User,$conf->SMTP_PWD);
$smtp->debug = true;
$state = $smtp->sendmail($conf->SMTP_TO_USER,$conf->SMTP_User,'你有'.count($EndangerMachineID).'台小鸡即将过期', $mailcontent,"HTML");

if($state==""){
	echo "邮件发送失败！请检查邮箱填写是否有误。\n";
	exit();
}
echo "邮件发送成功！\n";
echo "下班\n";
exit();

 ?>
