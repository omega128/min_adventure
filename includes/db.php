<?php
  /* This module establishes a connection to the database for pages that need it. */
  $db_host = 'mysql.kcchambers.dreamhosters.com';
  $db_user = 'minimal';
  $db_password = 'adventure';
  $db_dbname = 'minimal_adventure';
  $db = new mysqli($db_host, $db_user, $db_password, $db_dbname) or die ("Could not load database!");
?>