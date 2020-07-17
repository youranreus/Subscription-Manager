<?php
require_once('header.php');
require_once('../C/X.class.php');
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);

if(isset($_POST["submit"])){
  if($_POST["name"] == "" or $_POST["shop"] == "" or $_POST["date"] == "" or $_POST["fee"] == "" or $_POST["ip"] == "" or $_POST["star"] == ""){
    echo "<script>toastr.warning('别留空噢');</script>";
  }
  else{
      $X->addMachine($_POST["name"],$_POST["shop"],$_POST["date"],$_POST["fee"],$_POST["ip"],$_POST["star"]);
      header("location:/panel/index.php?msg=添加完成");
  }
}
?>
<div id="main">
    <h2>➕添加</h2>
    <div id="toolbar">
      <a class="tool-btn" href="/panel">🔙返回</a>
      <a class="tool-btn" href="add.php">➕添加</a>
      <a class="tool-btn" href="setting.php">⚙️设置</a>
    </div>
    <form id="add" action="/panel/add.php" method="post">
        <span>名字</span>
        <input type="text" name="name" >
        <span>服务商</span>
        <input type="text" name="shop" >
        <span>过期日期</span>
        <input type="text" name="date">
        <span>费用</span>
        <input type="text" name="fee">
        <span>IP</span>
        <input type="text" name="ip">
        <span>设置收藏？</span>
          <label>
            <input type="radio" name="star" value="1" class="a-radio">
            <span class="b-radio"></span>是
          </label>
          <label>
            <input type="radio" name="star" value="0" class="a-radio">
            <span class="b-radio"></span>否
          </label>
        <input type="submit" name="submit" class="submit" value="冲">
    </form>

</div>
<?php require_once('footer.php'); ?>
