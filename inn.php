<?php
  /* This page shows the Inn, from which the player can rest, or visit the restroom */
  include_once ("includes/session.php");
  include_once('includes/auth.php');

  $page_title = "Inn";
  include_once ("includes/header.php");
?>
<section>
<img src="images/inn.png" alt="It's an Inn, not to be confused with an in"/>
<p><strong>The Inn</strong> is a center for gossip, fun, and copious amounts of fermented vegetable products. They have magnificant bathrooms full of boasting, rooms upstairs where you can stay the night, and a convenient drunk tank out back, where you can also spend the night.</p>
<ul>
<li><a href="rest.php">Rest for the Night</a></li>
<li><a href="restroom.php">Visit the Restroom</a></li>
<li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>