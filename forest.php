<?php
  /* This page lets the player adventure in the forest, or head back to town */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  
  $page_title = "Forest of Doom";
  include_once ("includes/header.php");
?>
<section>
<img src="images/forest.png" alt="Spoooky!"/>
<p>You are in a dark, spooky woods.</p>
<ul>
<li>Sally forth, and find something to <a href="combat.php?action=sallyforth">kill</a>!</li>
<li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>