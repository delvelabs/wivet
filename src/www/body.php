<?php
  require_once('genclude.php');
?>
    <script>
      location.href="<?php echo $_SESSION['baseaddr']; ?>offscanpages/statistics.php?id=<?php echo $_SESSION['scan']['record']?>";
    </script>
