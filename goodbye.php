<?php
  /* This page bids the player farewell after they have deleted their account */
  $page_title = "Goodbye";
  include_once ("includes/header.php");
?>
<section>
<img src="images/bye.png" alt="Goodbye"/>
<p>Farewell, unnamed adventurer. We would refer to you by name, but we've already forgotten it, as you requested.</p>
<p>Would you like to <a href="index.php">try your hand at adventuring once again?</a></p>
</section>
<?php
  include_once ("includes/footer.php");
?>