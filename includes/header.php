<html>
<head>
  <title>Minimal Adventure! - <?php echo $page_title; ?></title>
  <link rel="stylesheet" href="styles/styles.css" type="text/css"/>
</head>
<body>
<?php
  // if user is logged in, show links for account options at the top of the page
  if (isset($_SESSION['you_are_logged_in'])) {
    $auth_bar = '<div id="authentication_bar"><a href="logout.php">Logout</a> | <a href="account.php">Account</a></div>';
  } else {
    // if the user is not logged in, show a link to let the player log in or join.
    $auth_bar = '<div id="authentication_bar"><a href="login.php">Login</a> | <a href="join.php">Join</a></div>';
  }
  
  echo $auth_bar;
?>

<div id="container">
<header>
  <h1>Minimal Adventure!</h1>
  <h2><?php echo $page_title; ?></h2>
</header>