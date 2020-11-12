<?php
//Medoo, yes
require  'medoo.php';
use Medoo\Medoo;

//创建/连接 数据库
$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => 'database.db'
]);

class main
{
    private $database;

    public function __construct()
    {
        $this->database = $GLOBALS["database"];
    }

    public function hello()
    {
        exit(json_encode(['msg'=>'backend']));
    }

    public function yo()
    {
        $msg = $_GET['msg'];
        exit(json_encode(['msg'=>$msg]));
    }

    public function login()
    {
        $key = $this->database->select('user','*');
        if($_GET['key'] == $key[0]['key']){
            exit(json_encode(['msg'=>'true']));
        }else{
            exit(json_encode(['msg'=>'false']));
        }
    }

    public function getMachineList()
    {
        if(isset($_GET['type']) and $_GET['type'] == 'all')
        {
            $machines = $this->database->select('machines',['rowid','name','liked','fee','location','HOST']);
        }else{
            $machines = $this->database->select('machines',['rowid','name','liked','fee','location','HOST'], [
                "liked" => '1'
            ]);
        }
        exit(json_encode($machines));
    }

    public function getInfo()
    {
        $info = array(
            "machineNum"=>0,
            "fee"=>0,
            "autoMachine"=>0,
            "feeLeast"=>0,
            "manuelMachine"=>0,
            "endangerMachine"=>0,
            "deadMachine"=>0
        );
        $machines = $this->database->select('machines',['fee','auto','liked','deadline','cycle']);
        $info["machineNum"] = count($machines);
        for($i=0;$i<$info["machineNum"];$i++){
            if ($machines[$i]['auto'] == 1){
                $info["autoMachine"] += 1;
            }else{
                $days = $this->dateDistance($machines[$i]['deadline'],date("Y-m-d"));
                if($days <= 15 and $days > 0){
                    $info["endangerMachine"] += 1;
                }
            }
            if ($machines[$i]['liked'] == 1){
                $info["feeLeast"] += $machines[$i]['fee'];
            }
            $info["fee"] += $machines[$i]['fee'];
        }

        $info["manuelMachine"] = $info["machineNum"] - $info["autoMachine"];

        exit(json_encode($info));
    }

    function dateDistance($first,$second) {
        $_start = $first;
        $_end = $second;
        $_start_time = strtotime($_start);
        $_end_time = strtotime($_end);
        $_timestamp = $_end_time-$_start_time;
        $_days = floor($_timestamp / 86400);
        return $_days;
    }

    public function getMachineDetail(){
        if(isset($_GET['id'])){
            $detail = $this->database->select('machines','*',[
                "rowid" => $_GET['id']
            ]);
            exit(json_encode($detail));
        }
    }

}