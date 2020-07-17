<?php
require_once('header.php');
require_once('../C/X.class.php');
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);
?>
<div id="main">
    <h2>⚙️设置</h2>
    <div id="toolbar">
      <a class="tool-btn" href="/panel">🔙返回</a>
      <a class="tool-btn" href="add.php">➕添加</a>
      <a class="tool-btn" href="setting.php">⚙️设置</a>
    </div>

    <h2 class='warning'>嘿！啥都没有</h2>



</div>
<?php require_once('footer.php'); ?>
