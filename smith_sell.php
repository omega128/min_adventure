<?php
  /* This page allows the player to sell equipment */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  include_once('includes/db.php');
  include_once('includes/player.php');
  
  // we'll need some output
  $messages = [];
  
  // let the player buy something
  if (isset($_GET['action'])) {  
    if ($_GET['action'] === 'sell') {
      // retrieve the info for this type of item
      $query = "SELECT * FROM user_item LEFT JOIN item ON item.item_id = user_item.item_id WHERE user_item_id=" . $db->escape_string($_GET[id]) . ";";
      $result = $db->query ($query);
      $item = $result->fetch_assoc();
      $gold = $item['item_price'];
      
      // Delete the instance of this item
      $query = "DELETE FROM user_item WHERE user_item_id=" . $db->escape_string($_GET[id]) . ";";
      $db->query ($query);
      
      // now, credit the player the appropriate loot
      $player->add_loot ($gold);
      
      // and inform the player
      $messages[] = "You have sold your " . $item['item_name'] . ' for $' . $item['item_price'];
      
      // check if you still have your weapon
      $query = "SELECT * FROM user_item WHERE user_item.user_id=" . $player->id . " AND user_item.item_id = " . $player->weapon_id . ";";
      $result = $db->query($query);
      if ($result->num_rows < 1) {
        $player->set_weapon(0);
        $messages[] = "You have sold your weapon!";
      }
      
      // ditto with the armor
      $query = "SELECT * FROM user_item WHERE user_item.user_id=" . $player->id . " AND user_item.item_id = " . $player->armor_id . ";";
      $result = $db->query($query);
      if ($result->num_rows < 1) {
        $player->set_armor(0);
        $messages[] = "You have sold your armor!";
      }
    }
    
    // does the player want to equip something?
    if ($_GET['action'] === 'equip') {
        // get info on the item
        $query = "SELECT * FROM item LEFT JOIN user_item ON user_item.item_id = item.item_id WHERE user_id = " . $player->id . " AND user_item_id = " . $db->escape_string($_GET['id']);
        $result = $db->query ($query);
        $item = $result->fetch_assoc();
      
        // is it a weapon or armor?
        if ($item['item_type_id'] == 3) {
          $player->set_weapon ($item['item_id']);
        }
        else if ($item['item_type_id'] == 4) {
          $player->set_armor ($item['item_id']);
        }
      
        $messages[] = "You have equipped your " . $item['item_name'] . "!";
    }
  }
  
  $page_title = "Sell to Smith";
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
  $query = "SELECT * FROM user_item LEFT JOIN item ON item.item_id=user_item.item_id WHERE user_id = " . $player->id;
  $result = $db->query ($query);
  while ($record = $result->fetch_assoc()) {
    $item_id = $record['item_id'];
    $item_name = $record['item_name'];
    $item_level = $record['item_value'];
    $item_price = $record['item_price'] / 2; // all items sell for half their full price
    $item_descr = $record['item_descr'];    
    $user_item_id = $record['user_item_id'];
    
    echo "<tr>
    <th>$item_name</th>
    <td>$item_level</td>
    <td>$$item_price</td>
    <td>$item_descr</td>
    <td>
    <a href=\"smith_sell.php?action=sell&id=$user_item_id\">Sell</a>
    <a href=\"smith_sell.php?action=equip&id=$user_item_id\">Equip</a>
    </td>
    </tr>";    
  }  
?>
</table>

<ul>
<li><a href="smith_buy.php">Buy</a> new equipment</li>
<li><a href="map.php">Leave</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>