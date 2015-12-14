<?php
  /* This page lets the player buy things from the Smith */
  include_once ("includes/session.php");  
  include_once('includes/auth.php');
  include_once('includes/db.php');
  include_once('includes/player.php');
  
  // we'll need feedback for this
  $messages = [];
  
  // let the player buy something
  if (isset($_GET['action'])) {  
    if ($_GET['action'] === 'buy') {
    
      // get info on this item
      $query = "SELECT * FROM item WHERE item_id = " . $db->escape_string($_GET['id']);
      $result = $db->query ($query);
      $item = $result->fetch_assoc();
      
      // can the player afford this item?
      if ($player->gold > $item['item_price']) {
        // deduct the gold from the player        
        $player->remove_loot ($item['item_price']);

        // create a user_item entry
        $query = 'INSERT INTO user_item VALUES (NULL, ' . $player->id . ', ' . $item['item_id'] . ');';
        $db->query ($query);

        // ask if the player wants to equip this new item
        $messages[] = "You bought a ". $item['item_name'] . "!";
        $messages[] = "Would you like to <a href=\"smith_buy.php?action=equip&id=" . $item['item_id'] . "\">equip</a> your purchase?";
      }
      else {
        $messages[] = "You cannot afford to buy that!";
      }
    }
    
    // does the player want to equip something?
    if ($_GET['action'] === 'equip') {
      
      // verify the user has the specified item
      $query = "SELECT * FROM user_item WHERE user_id = " . $player->id . " and item_id = " . $db->escape_string($_GET['id']);
      $result = $db->query ($query);
      
      if ($result->num_rows > 0) {        
        // get info on the item
        $query = "SELECT * FROM item WHERE item_id = " . $db->escape_string($_GET['id']);
        $result = $db->query ($query);
        $item = $result->fetch_assoc();
      
        // is it a weapon or armor?
        if ($item['item_type_id'] == 3) {
          $player->set_weapon ($item['item_id']);
        }
        else if ($item['item_type_id'] == 4) {
          $player->set_armor ($item['item_id']);
        }
      
        $messages[] = "You have equipped your new " . $item['item_name'] . "!";
      }
      else {
        $messages[] = "You do not have that!";
      }
      
    }
  }
  
  $page_title = "Buy from Smith";
  include_once ("includes/header.php");
?>
<section>
<?php
foreach ($messages as $message) {
  echo "<p><strong>$message</strong></p>";
}
?>
<img src="images/smith.png" alt="Smith is such a common name..."/>
<p>You have <strong>$<?php echo $player->gold; ?></strong>. You are current equipping
<?php
  $weapon_name = $player->weapon['item_name'];
  $armor_name = $player->armor['item_name'];
  
  $weapon_level = $player->weapon['item_value'];
  $armor_level = $player->armor['item_value'];

  echo "$weapon_name (level $weapon_level) and $armor_name (level $armor_level)"; ?>
<h2>Weapons and Armor</h2>
<table>
<tr>
  <th>Name</th>
  <th>Level</th>
  <th>Price
  <th>Description</th>
  <th>Action</th>
</tr>
<?php
  $query = "SELECT * FROM item WHERE item_type_id > 1 ORDER BY item_value, item_type_id, item_name;";
  $result = $db->query ($query);
  while ($record = $result->fetch_assoc()) {
    $item_id = $record['item_id'];
    $item_name = $record['item_name'];
    $item_level = $record['item_value'];
    $item_price = $record['item_price'];
    $item_descr = $record['item_descr'];
    
    echo "<tr>
    <th>$item_name</th>
    <td>$item_level</td>
    <td>$$item_price</td>
    <td>$item_descr</td>
    <td>
    <a href=\"smith_buy.php?action=buy&id=$item_id\">Buy</a>
    </td>
    
    </tr>";    
  }  
?>
</table>

<ul>
<li><a href="smith_sell.php">Sell</a> your own</li>
<li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>