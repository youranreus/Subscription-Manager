<?php
require_once('header.php');
require_once('../C/X.class.php');
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);
$id = $_GET["id"];
$machineDetail = $X->getMachineDetail($id);

if(isset($_POST["submit"])){
  if($_POST["name"] == "" or $_POST["shop"] == "" or $_POST["date"] == "" or $_POST["fee"] == "" or $_POST["ip"] == "" or $_POST["star"] == ""){
    echo "<script>toastr.warning('别留空噢');</script>";
  }
  else{
      if($X->editMachine($id,$_POST["name"],$_POST["shop"],$_POST["date"],$_POST["fee"],$_POST["ip"],$_POST["star"]))
      {
        header("location:/panel/detail.php?msg=修改完成&id=".$id);
      }
      else{
        echo "<script>toastr.error('修改失败')</script>";
      }

  }
}
?>
<div id="main">
    <h2>✒️编辑[<?php echo $machineDetail["name"]; ?>]</h2>
    <div id="toolbar">
      <a class="tool-btn" href="/panel">🔙返回</a>
      <a class="tool-btn" href="add.php">➕添加</a>
      <a class="tool-btn" href="setting.php">⚙️设置</a>
    </div>
    <form id="add" action="/panel/edit.php?id=<?php echo $id; ?>" method="post">
        <span>名字</span>
        <input type="text" name="name" value="<?php echo $machineDetail["name"]; ?>">
        <span>服务商</span>
        <input type="text" name="shop" value="<?php echo $machineDetail["shop"]; ?>">
        <span>过期日期</span>
        <input type="text" name="date" value="<?php echo $machineDetail["gdate"]; ?>">
        <span>费用</span>
        <input type="text" name="fee" value="<?php echo $machineDetail["fee"]; ?>">
        <span>IP</span>
        <input type="text" name="ip" value="<?php echo $machineDetail["ip"]; ?>">
        <span>设置收藏？</span>
          <label>
            <input type="radio" name="star" value="1" <?php if ($machineDetail["star"] == 1 ){echo "checked";}?> class="a-radio">
            <span class="b-radio"></span>是
          </label>
          <label>
            <input type="radio" name="star" value="0" <?php if ($machineDetail["star"] == 0) echo "checked";?> class="a-radio">
            <span class="b-radio"></span>否
          </label>
        <input type="submit" name="submit" class="submit" value="冲">
    </form>

</div>
<?php require_once('footer.php'); ?>
