<?php
      session_start();
      session_destroy();
      header("Location: ../Web/login.php");
      exit;
?>