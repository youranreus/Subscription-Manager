<?php
require_once('header.php');
require_once('../C/X.class.php');
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);
$id = $_GET["id"];
$machineDetail = $X->getMachineDetail($id);
?>
<div id="main">
    <h2>🏷️<?php echo $machineDetail["name"]; ?></h2>
    <div id="toolbar">
      <a class="tool-btn" href="/panel">🔙返回</a>
      <a class="tool-btn" href="edit.php?id=<?php echo $id; ?>">✒️编辑</a>
      <a class="tool-btn" href="add.php">➕添加</a>
      <a class="tool-btn" href="setting.php">⚙️设置</a>
    </div>

    <div id="machine-detail" class="clear">
      <div class="machine-detail-item">
        <h3>运营商</h3>
        <p><?php echo $machineDetail["shop"]; ?></p>
      </div>
      <div class="machine-detail-item">
        <h3>IP</h3>
        <p><?php echo $machineDetail["ip"]; ?></p>
      </div>
      <div class="machine-detail-item">
        <h3>过期日期</h3>
        <p><?php echo $machineDetail["gdate"]; ?></p>
      </div>
      <div class="machine-detail-item">
        <h3>养鸡成本</h3>
        <p><?php echo $machineDetail["fee"]; ?>/月</p>
      </div>
    </div>

</div>
<?php require_once('footer.php'); ?>
