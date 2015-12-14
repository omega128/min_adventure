<?php
  include_once ('includes/db.php');
  
  /* The Monster class is a simple record to store a particular instance of a monster. As PHP doesn't allow objects to be directly stored in a _SESSION, variable,
     this object will need to be serialized and unserialized before and after each use. */
  class Monster {
    public $id;
    public $level;
    public $name;
    public $descr;
    public $pic;
    public $health;
    public $gold;
    public $atk;
    public $def;
    public $attack_type;

    function __construct ($db, $id) {
      // Retrieve the monster's stats from the database, and load them into our object.
      $query = "SELECT * FROM monster WHERE monster_id=$id;";
      $result = $db->query($query);
      $record = $result->fetch_assoc();
            
      // load these values into our new monster as starting stats
      $this->id = $record['monster_id'];
      $this->level = $record['monster_level'];
      $this->name = $record['monster_name'];
      $this->descr = $record['monster_descr'];
      $this->pic = $record['monster_pic'];
      $this->health = $record['monster_health'];
      $this->gold = $record['monster_gold'];
      $this->atk = $record['monster_atk'];
      $this->def = $record['monster_def'];
      $this->attack_type = $record['monster_attack_type'];
    }
    
    // A monster can be hurt during combat.
    function hurt ($damage) {
      $this->health = $this->health - $damage;
    }
    
  }

?>