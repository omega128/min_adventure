<?php
  /* This page resets the player's health to maximum */
  include_once ("includes/session.php");
  include_once ("includes/auth.php");
  include_once ("includes/player.php");

  // restore the player's health
  $player->rest();
  
  $page_title = "Rest";
  include_once ("includes/header.php");
?>
<section>
<img src="images/rest.png" alt="Zzz"/>
<p>You rest overnight at the Inn. Your health has been restored.</p>
<ul>
  <li><a href="inn.php">Back to the Inn</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>