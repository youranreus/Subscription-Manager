<?php
require 'main.class.php';
$X = new main();
echo "\n";
echo "开始".date("Y-m-d")."任务\n";
$Machine = $X->Cron();
$title = "小鸡管理推送";

$endangerMachine = implode(',', $Machine["endanger"]);
$deadMachine = implode(',', $Machine["dead"]);
$autoMachine = implode(',', $Machine["auto"]);

$msg = "
    一共有".count($Machine["endanger"])."台小鸡即将到期。[".$endangerMachine."]
    有".count($Machine["dead"])."台小鸡已经过期。[".$deadMachine."]
    有".count($Machine["auto"])."台小鸡自动续费。[".$autoMachine."]
    请前往小鸡管理查看
    ";
file_get_contents('http://sc.ftqq.com/SCU108711Te987fd883e60a263488101a8d91f1a965f2e0fe2eee7f.send?text='.urlencode($title).'&desp='.urlencode($msg));