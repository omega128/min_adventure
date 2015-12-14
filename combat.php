<?php
  /* This page handles combat. */
  
  include_once ("includes/session.php");
  include_once ('includes/auth.php');
  include_once ('includes/monster.php');
  include_once ('includes/player.php');
  include_once ('includes/db.php');
  
  // unserialize the monster stored in the session, so we can use it.
  $monster = unserialize($_SESSION['monster']);
    
  // if no action is specified, redirect the player back to the map
  if (!isset($_GET['action'])) { header ("Location: map.php"); die(); }
  
  // let's store this in a local variable
  $action = $_GET['action'];
  
  // the player wants a new, random encounter
  if ($action === 'sallyforth') {
  
    // estimate the player's "level" from the average of their weapon and armor.
    $playerLevel = ($player->weapon['item_value']  + $player->armor['item_value']) / 2;
    
    // now that we've got a level, randomly choose a single monster of at least this level.
    $query = "SELECT monster_id FROM monster WHERE monster_level <= " . ($playerLevel + 1) . ' ORDER BY RAND() LIMIT 0,1;';
    $results = $db->query ($query);
    $record = $results->fetch_assoc();
    $monster_id = $record['monster_id'];
       
    // create a new monster from the database, and serialize it into the session.
    $monster = new Monster($db, $monster_id);
    $_SESSION['monster'] = serialize($monster);
    
    // Tell the player what they are up against.
    $flavor = "You have encountered a " . $monster->name;
    
    // estimate if the player has a chance
    if ($monster->level > $playerLevel) {
      $flavor = $flavor . " and it looks tougher than you";
    }    
    $flavor = $flavor . "!";
  }
  
  // The player wants to flee, so forget this monster and head back to the map screen
  if ($action === 'flee') {
    header ("Location: forest.php");
    die ();
  }
  
  // the player attacks the monster
  if ($action === 'attack') {
    // roll damage as a number from 1-6 plus the weapon's value, minus the monster's defense.
    $damage = rand(1, 6) + $player->weapon['item_value'] - $monster->def;
    if ($damage < 0) $damage = 1;
    
    // the player attacks
    $flavor = "<strong>You attack the " . $monster->name . ", for $damage damage!</strong>";
    $monster->hurt ($damage);
    $_SESSION['monster'] = serialize($monster);
    
    // the monster then attacks
    $damage = rand(1, 4) + $monster->atk - $player->armor['item_value'];
    if ($damage < 0) $damage = 1;
    $flavor = $flavor . "<br><strong>The " . $monster->name . " attacks YOU for $damage damage!</strong>";
    
    // record how much damage the player took.
    $player->hurt ($damage);
  }
  
  // if the player has zero or less health, redirect to the "dead" page.
  if ($player->health < 1) { header ("Location: dead.php"); die(); }
  
  // if the monster has zero or less health, redirect to the "victory" page.
  if ($monster->health < 1) { header ("Location: loot.php"); die(); }
  
  $page_title = "Combat";
  include_once ("includes/header.php");
?>
<section>
<p><?php echo $flavor; ?></p>
<img src="images/monsters/<?php echo $monster->pic; ?>" alt="<?php echo $monster->name; ?>"/>

<table>
<tr>
  <td></td><th>Monster</th><td></td><th>You</th>
</tr>
<tr>
  <th>Health</th><td><?php echo $monster->health; ?></td>
  <th>Health</th><td><?php echo $player->health; ?></td>
</tr>
<tr>
  <th>Attack</th><td><?php echo $monster->atk; ?></td>
  <th>Attack</th><td><?php echo $player->weapon['item_value']; ?></td>
</tr>

<tr>
  <th>Defense</th><td><?php echo $monster->def; ?></td>
  <th>Defense</th><td><?php echo $player->armor['item_value']; ?></td>
</tr>

</table>

<!-- Display Combat Options -->
<h3>What Do You Do?!</h3>
<ul>
<li><a href="combat.php?action=attack">Attack</a></li>
<li><a href="combat.php?action=flee">Flee</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>