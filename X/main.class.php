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
    private $key = 'jojo';
    private $serverChanKey = 'key';

    public function __construct()
    {
        $this->database = $GLOBALS["database"];
    }

    public function hello()
    {
        exit(json_encode(['msg'=>'backend']));
    }

    public function getServerChanKey(){
        return $this->serverChanKey;
    }

    public function yo()
    {
        $msg = $_GET['msg'];
        exit(json_encode(['msg'=>$msg]));
    }

    public function login()
    {
        if($_GET['key'] == $this->key){
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
                $days = $this->dateDistance(date("Y-m-d"),$machines[$i]['deadline']);
                if($days <= 15 and $days >= 0){
                    $info["endangerMachine"] += 1;
                    
                }
                if($days < 0){
                    $info["deadMachine"] += 1;
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

    public function updateMachineDetail(){
        if(isset($_GET['id'])){
            $result = $this->database->update("machines", [
                "name" => $_GET["name"],
                "liked" => $_GET["liked"],
                "deadline" => $_GET["deadline"],
                "location" => $_GET["location"],
                "fee" => $_GET["fee"],
                "cycle" => $_GET["cycle"],
                "auto" => $_GET["auto"],
                "panel" => $_GET["panel"],
                "info" => $_GET["info"],
                "HOST" => $_GET["HOST"],
                "ip" => $_GET["ip"]
            ], [
                "rowid" => $_GET["id"]
            ]);
            exit(json_encode($result->rowCount()));
        }
    }

    public function AddMachine(){
        if(isset($_GET['id'])){
            $result = $this->database->insert("machines", [
                "name" => $_GET["name"],
                "liked" => $_GET["liked"],
                "deadline" => $_GET["deadline"],
                "location" => $_GET["location"],
                "fee" => $_GET["fee"],
                "cycle" => $_GET["cycle"],
                "auto" => $_GET["auto"],
                "panel" => $_GET["panel"],
                "info" => $_GET["info"],
                "HOST" => $_GET["HOST"],
                "ip" => $_GET["ip"]
            ]);
            exit(json_encode($result->rowCount()));
        }
    }

    public function DeleteMachine(){
        if(isset($_GET['id'])) {
            $result = $this->database->delete("machines", [
                "rowid" => $_GET["id"]
            ]);
            exit(json_encode($result->rowCount()));
        }
    }

    public function Cron(){

        $machines = $this->database->select('machines',['rowid','name','liked','deadline','auto','cycle']);

        $machinesNum = count($machines);
        $Machine = [];
        $Machine["endanger"] = [];
        $Machine["dead"] = [];
        $Machine["auto"] = [];

        for($i=0;$i<$machinesNum;$i++){
            echo "------\n";
            echo '名称:'.$machines[$i]["name"]."\n";
            $days = $this->dateDistance(date("Y-m-d"),$machines[$i]['deadline']);
            echo '距离过期'.$days."天\n";
            if($days <=7 and $days>=0 and $machines[$i]['auto'] == 0){
                $Machine["endanger"][] = $machines[$i]['name'];
            }
            if($days < 0 and $machines[$i]['auto'] == 0){
                $Machine["dead"][] = $machines[$i]['name'];
            }

            if($days == 0 and $machines[$i]['auto'] == '1'){

                $this->database->update("machines", [
                    "deadline" => date('Y-m-d',strtotime("+".$machines[$i]['cycle']." day"))
                ], [
                    "rowid" => $machines[$i]['rowid']
                ]);
                $Machine["auto"][] = $machines[$i]['name'];
            }

        }

        return $Machine;

    }

}