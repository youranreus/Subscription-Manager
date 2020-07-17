<div id="status">
  <div id="total-fee">
    <p>目前养鸡成本：￥<?php echo $X->getTotalFee(); ?>/年</p>
  </div>
  <div id="total-EndangerMachine">
    <p><a href="/panel/cat.php?cat=endanger">即将到期🐥：<?php echo count($X->getEndangerMachine()); ?>台</a></p>
  </div>
  <div id="total-DeadMachine">
    <p><a href="/panel/cat.php?cat=dead">已经到期🐥：<?php echo count($X->getDeadMachine()); ?>台</a></p>
  </div>
  <div id="total-StarMachine">
    <p><a href="/panel/cat.php?cat=star">⭐🐥：<?php echo count($X->getStarMachine()); ?>台</a></p>
  </div>
</div>
</body>

</html>
