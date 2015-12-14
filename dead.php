<?php
  /* This page shows when the player is dead. It resets the player's health to 1, and lets the user return to the game. */
  
  include_once ("includes/session.php");
  include_once ("includes/auth.php");
  include_once ("includes/player.php");
  
  $player->come_back_from_the_dead();
  
  $page_title = "You're Dead!";
  include_once ("includes/header.php");
?>
<section>
<img src="images/dead.png" alt="This player is no more. They have ceased to be."/>
<p>You have perished! Luckily, this game is rather forgiving on that front, so you were only MOSTLY dead. In fact, reports of your death were an exaggeration, and you limp out of the forest and back to town.</p>
<ul>
<li><a href="map.php">Continue</a></li>
</ul>
</section>
<?php include_once ("includes/footer.php"); ?>