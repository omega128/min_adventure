<?php
  /* This page randomly gives the player treasure based on the monster in the session. */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  include_once('includes/monster.php');  
  include_once('includes/player.php');
  
  // We need the monster's stats to calculate how much gold the player receives.
  $monster = unserialize($_SESSION['monster']);
  
  // Monsters drop 1d6 gold times their 'gold' value  
  $gold = rand(1, 3) * $monster->gold;
  $player->add_loot ($gold);
  
  // apart from it's name and picture, we can now remove the monster from the session, to make sure the player can't reload the page over and over and cheat the system easily
  $monster_name = $monster->name;
  $monster_pic = $monster->pic;
  unset($_SESSION['monster']);
  
  $page_title = "You Have Defeated Your Opponent!";
  include_once ("includes/header.php");
?>
<section>
<img src="images/monsters/dead/<?php echo $monster_pic; ?>" alt="This fallen foe has fallen down."/>

<p>The <?php echo $monster_name; ?> is vanquished!</p>
<h2>You Receive</h2>
<table>
<tr>
  <th>Gold</th>
</tr>
<tr>
  <td>$<?php echo $gold; ?></td>
</tr>
</table>
<ul>
  <li><a href="combat.php?action=sallyforth">Continue looking for things to fight</a></li>
  <li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>