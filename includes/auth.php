<?php
  // this module ensures that the user is logged in. If they aren't, it redirects back to the index page.
  if (!isset($_SESSION["you_are_logged_in"])) {  
    header ("Location: index.php");
    die();
  }  
?>