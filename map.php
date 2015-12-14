<?php
  /* This page lets the player travel to various locations */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  
  $page_title = "Where Do You Want To Go?";
  include_once ("includes/header.php");
?>
<section>
  <p>Select your destination!</p>
  <p><img src="images/map.png" width="597" height="436" border="0" usemap="#map" /></p>
  <map name="map">
  <area shape="rect" coords="10,80,109,189" alt="Inn" href="inn.php" />
  <area shape="rect" coords="131,38,231,166" alt="Smith" href="smith.php" />
  <area shape="rect" coords="301,354,596,434" alt="Forest of Doom" href="forest.php" />
  </map>
</section>
<?php
  include_once ("includes/footer.php");
?>