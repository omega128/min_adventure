<?php
  /* This module logs the user out, and redirects to the welcome page. */
  if (isset($db)) {
    $db->close();
  }
  
  include_once ("includes/session.php");
  session_unset();
  session_destroy();
  header ("Location: index.php");
  die();
?>
