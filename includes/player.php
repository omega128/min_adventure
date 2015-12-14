<?php
  include_once ('includes/db.php');
  
/* The Player class represents the player. Things are a little complicated as the player exists in three places at once:
   - this object, which is stored in the $player variable whenever this module is loaded,
   - the database, where permanent changes are stored for the next time the player logs in,
   - and the $_SESSION[] variables, where login info is kept
   
   this object helps bridge the gap a bit.
*/ 
   
  class Player {
    public $db;
    public $id;
    public $name;
    public $health;
    public $gold;
    public $weapon_id;
    public $armor_id;
    public $weapon;
    public $armor;

    // the constructor accepts a reference for the mysqli database, and the user's id.
    function __construct ($db, $id) {
      // store this so we can use it later to make changes.
      $this->db = $db;
    
      // Retrieve the player's stats from the database, and load them into our object.      
      $query = "SELECT * FROM user WHERE user_id=$id";
      $result = $db->query($query);
      $record = $result->fetch_assoc();
      
      // load the values into our new object
      $this->id = $record['user_id'];
      $this->name = $record['user_name'];
      $this->health = $record['user_health'];
      $this->gold = $record['user_gold'];
      $this->weapon_id = $record['weapon_id'];
      $this->armor_id = $record['armor_id'];
      
      // now something a little different... get and store the details for both weapons and armor, so we don't have to query the
      // database again.
      $query = "SELECT * FROM item WHERE item_id=" . $this->weapon_id;
      $result = $db->query($query);
      $record = $result->fetch_assoc();
      $this->weapon = $record;
      
      $query = "SELECT * FROM item WHERE item_id=" . $this->armor_id;
      $result = $db->query($query);
      $record = $result->fetch_assoc();
      $this->armor = $record;
    }

    // resting resets the player's health to 20.
    function rest () {
      $query = "UPDATE user SET user_health = 20 WHERE user_id=" . $this->id;
      $this->db->query ($query);      
      $this->health = 20;
    }

    // when the player dies, they return, but at 1 health.
    function come_back_from_the_dead () {
      $query = "UPDATE user SET user_health = 1 WHERE user_id=" . $this->id;
      $this->db->query ($query);      
      $this->health = 1;
    }
    
    // during combat, the player can take damage from time to time
    function hurt ($damage) {
      $this->health = $this->health - $damage;
      $query = "UPDATE user SET user_health = " . $this->health . " WHERE user_id=" . $this->id;
      $this->db->query ($query);
    } 

    // the player can also earn gold when they win a fight.
    function add_loot ($gold) {
      $this->gold = $this->gold + $gold;
      $query = "UPDATE user SET user_gold = " . $this->gold . " WHERE user_id=" . $this->id;
      $this->db->query ($query);
    }    
   
    // and of course, the player can spend that gold again.
    function remove_loot ($gold) {
      $this->gold = $this->gold - $gold;
      $query = "UPDATE user SET user_gold = " . $this->gold . " WHERE user_id=" . $this->id;
      $this->db->query ($query);    
    }
    
    // sometimes we need to change the player's equipped weapon
    function set_weapon ($new) {
      // change the weapon
      $query = "UPDATE user SET weapon_id = " . $new . " WHERE user_id=" . $this->id;
      $this->db->query ($query);
      $this->weapon_id = $new;
      
      // retrieve the statistics for that weapon
      $query = "SELECT * FROM item WHERE item_id = " . $this->weapon_id;
      $result = $this->db->query($query);
      $record = $result->fetch_assoc();
      $this->weapon = $record;
    }
    
    // change the player's equipped armor
    function set_armor ($new) {
      $query = "UPDATE user SET armor_id = " . $new . " WHERE user_id=" . $this->id;
      $this->db->query ($query);
      $this->armor_id = $new;
      
      // and retrieve our new armor stats
      $query = "SELECT * FROM item WHERE item_id=" . $this->armor_id;
      $result = $this->db->query($query);
      $record = $result->fetch_assoc();
      $this->armor = $record;
    }
    
    
  }
  
  // any page that loads this module will need to access the player, so we can define this here.
  $player = new Player($db, $_SESSION['id']);
?>