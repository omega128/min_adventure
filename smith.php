<?php
  /* This page offers to let the player buy or sell at the Smith */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  include_once('includes/db.php');
  include_once('includes/player.php');
    
  $page_title = "Smith";
  include_once ("includes/header.php");
?>
<section>
<img src="images/smith.png" alt="Smith is such a common name..."/>
<p>Mr. Smith, <strong>The Smith</strong>, can sell you armor and weapons at highly affordable prices.</p>

<p>You have <strong><?php echo $player->gold; ?></strong> gold. You are current equipping
<?php
  $weapon_name = $player->weapon['item_name'];
  $weapon_level = $player->weapon['item_value'];
  
  $armor_name = $player->armor['item_name'];  
  $armor_level = $player->armor['item_value'];

  echo "$weapon_name (level $weapon_level) and $armor_name (level $armor_level)"; ?>
<h2>Do You Want To...</h2>
<ul>
  <li><a href="smith_buy.php">Buy</a> new equipment</li>
  <li><a href="smith_sell.php">Sell</a> your own</li>
  <li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>