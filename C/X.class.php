<?php

class X
{

  public function __construct($dbservername, $dbusername, $dbpassword, $dbdbname){
    $this->servername = $dbservername;
    $this->username = $dbusername;
    $this->password = $dbpassword;
    $this->dbname = $dbdbname;
  }

  public function getMachine(){

    $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
    $sql = "SELECT id,name,shop,gdate,fee,ip,star FROM machine";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          if($row['star'] == 1){
            $star = "⭐";
          }else{
            $star = "";
          }
            echo "
            <div class='machine-item'>
              <a href='detail.php?id=".$row['id']."'><h3>🏷️".$row["name"].$star."</h3></a>
              <div class='machine-item-info clear'>
                <span class='left'>".$row["shop"]."</span>
                <span class='right'>🕰️".$row["gdate"]."过期</span>
              </div>
            </div>
            ";
        }
    } else {
        echo "<h2 class='warning'>还没有小鸡！</h2>";
    }
    $conn->close();
    }

    public function getMachineByCat($cat){

      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT id,name,shop,gdate,fee,ip,star FROM machine";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($row['star'] == 1){
              $star = "⭐";
            }else{
              $star = "";
            }

            switch ($cat) {
              case 'star':
                if($row['star']==1){
                  echo "
                  <div class='machine-item'>
                    <a href='detail.php?id=".$row['id']."'><h3>🏷️".$row["name"].$star."</h3></a>
                    <div class='machine-item-info clear'>
                      <span class='left'>".$row["shop"]."</span>
                      <span class='right'>🕰️".$row["gdate"]."过期</span>
                    </div>
                  </div>
                  ";
                }else{}
              break;

              case 'endanger':
                $date=strtotime (date('y-m-d'));
                $gdate=strtotime ($row["gdate"]);
                $leftTime=ceil(($gdate-$date)/86400);

                if($leftTime <=15 && $leftTime > 0){
                  echo "
                  <div class='machine-item'>
                    <a href='detail.php?id=".$row['id']."'><h3>🏷️".$row["name"].$star."</h3></a>
                    <div class='machine-item-info clear'>
                      <span class='left'>".$row["shop"]."</span>
                      <span class='right'>🕰️".$row["gdate"]."过期</span>
                    </div>
                  </div>
                  ";
                }

                case 'dead':
                  $date=strtotime (date('y-m-d'));
                  $gdate=strtotime ($row["gdate"]);
                  $leftTime=ceil(($gdate-$date)/86400);

                  if($leftTime < 0){
                    echo "
                    <div class='machine-item'>
                      <a href='detail.php?id=".$row['id']."'><h3>🏷️".$row["name"].$star."</h3></a>
                      <div class='machine-item-info clear'>
                        <span class='left'>".$row["shop"]."</span>
                        <span class='right'>🕰️".$row["gdate"]."过期</span>
                      </div>
                    </div>
                    ";
                  }

              default:

                break;
            }

          }
      } else {
          echo "<h2 class='warning'>还没有小鸡！</h2>";
      }
      $conn->close();
      }

    public function addMachine($name,$shop,$date,$fee,$ip,$star){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "INSERT INTO machine (name,shop,gdate,fee,ip,star) VALUES ('".$name."','".$shop."','".$date."','".$fee."','".$ip."','".$star."')";
      if (mysqli_query($conn, $sql)) {
        echo "<script>toastr.success('添加成功！')</script>";
      } else {
        echo "<script>toastr.warning('添加失败');</script>";
      }
      $conn->close();
    }

    public function editMachine($id,$name,$shop,$date,$fee,$ip,$star){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "UPDATE machine SET name='".$name."',shop='".$shop."',gdate='".$date."',fee='".$fee."',ip='".$ip."',star='".$star."' WHERE id=".$id;
      if (mysqli_query($conn, $sql)) {
        return true;
      } else {
        return false;
      }
      $conn->close();
    }

    public function getTotalFee(){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT fee FROM machine";
      $result = $conn->query($sql);

      $totalFee = 0;

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $totalFee = $totalFee + $row["fee"];
          }
      }
      $conn->close();
      return $totalFee*12;
    }

    public function getMachineDetail($id){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT name,shop,gdate,fee,ip,star FROM machine WHERE id=".$id;
      $result = $conn->query($sql);

      $machineDetail = array();

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $machineDetail = $row;
          }
      }
      $conn->close();
      return $machineDetail;
    }


    public function getEndangerMachine(){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT id,gdate FROM machine";
      $result = $conn->query($sql);

      $EndangerMachineID = array();
      $date=strtotime (date('y-m-d'));

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $gdate=strtotime ($row["gdate"]);
            $leftTime=ceil(($gdate-$date)/86400);
            if($leftTime <= 15 and $leftTime >0){
              $EndangerMachineID[] = $row["id"];
            }
          }
      }
      $conn->close();
      return $EndangerMachineID;
    }

    public function getDeadMachine(){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT id,gdate FROM machine";
      $result = $conn->query($sql);

      $DeadMachineID = array();
      $date=strtotime (date('y-m-d'));

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $gdate=strtotime ($row["gdate"]);
            $leftTime=ceil(($gdate-$date)/86400);

            if($leftTime < 0){
              $DeadMachineID[] = $row["id"];
            }
          }
      }
      $conn->close();
      return $DeadMachineID;
    }

    public function cleanDeadMachine(){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

      $DeadMachineID = $this->getDeadMachine();
      $number = count($DeadMachineID)-1;
      for($i=0;$i<=$number;$i++){
        $sql = "DELETE FROM machine WHERE id = ".$DeadMachineID[$i];
        $result = $conn->query($sql);
      }
      $conn->close();
    }

    public function getStarMachine(){
      $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
      $sql = "SELECT id,star FROM machine";
      $result = $conn->query($sql);

      $StarMachineID = array();

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($row['star'] == 1){
              $StarMachineID[] = $row["id"];
            }
          }
      }
      $conn->close();
      return $StarMachineID;
    }


}
