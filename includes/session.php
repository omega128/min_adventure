<?php
/* This file was originally created to deal with Dreamhost's session permissions bug.
   I think I've gotten it sorted out, but these lines may still be useful for transferring to a different server,
   so I'm going to keep them in the comments.
   
ini_set('session.save_path',$_SERVER['DOCUMENT_ROOT'].'/session');
php_value session.save_path /home/youraccount/example.com/sesstmp
die($_SERVER['DOCUMENT_ROOT'].'/session');*/

session_start();
?>