<?php
require_once('header.php');
require_once('../C/X.class.php');
$X = new X($conf->db_servername, $conf->db_username, $conf->db_password, $conf->db_name);
$cat = $_GET["cat"];
$title = "";
switch ($cat) {
  case 'dead':
    $title = "过期🐥";
    break;
  case 'endanger':
    $title = "即将过期🐥";
    break;
  case 'star':
    $title = "⭐🐥";
    break;

  default:
    $title = "参数缺失";
    break;
}
if(isset($_GET["clear"]) and $_GET["clear"]==1){
  $X->cleanDeadMachine();
  echo "<script>toastr.info('删除完成');</script>";
}
?>
<div id="main">
    <h2><?php echo $title; ?></h2>
    <div id="toolbar">
      <a class="tool-btn" href="/panel">🔙返回</a>
      <?php if($cat == 'dead'){echo '<a class="tool-btn" href="/panel/cat.php?cat=dead&clear=1">✂一键清理</a>';} ?>
      <a class="tool-btn" href="add.php">➕添加</a>
      <a class="tool-btn" href="setting.php">⚙️设置</a>
    </div>



    <div id="machines" class="clear">
      <?php
        $X->getMachineByCat($cat);
      ?>
    </div>


</div>

<?php require_once('footer.php'); ?>
