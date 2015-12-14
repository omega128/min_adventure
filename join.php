<?php
  /* This page allows the player to create a new account. */
  include_once ("includes/session.php");
  include_once ("includes/db.php");
  
  // we need to record errors as we go  
  $errors = [];
  
  // if the user has sent the form
  if (isset($_POST['sent'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    
    // check if this user already exists
    $query = "SELECT * FROM user WHERE user_name='" . $db->escape_string($username) . "';";
    $result = $db->query($query);
    $record = $result->fetch_assoc();
    
    // if he/she/xe don't already exist...
    if ($result->num_rows == 0) {
      // create the user account, using the bare minimum information.
      $new_user_name = $db->escape_string($username);
      $new_user_pass = $db->escape_string($password);
      $new_user_is_new = TRUE;
      
      $query = "INSERT INTO user (user_name, user_password, user_health, weapon_id, armor_id) VALUES ('$new_user_name', \"$new_user_pass\", 20, 2, 3);";
      $result = $db->query($query) or die ("Could not create user account!");

      // retrieve the new user account
      $query = "SELECT * FROM user WHERE user_name='" . $new_user_name . "';";
      $result = $db->query($query);
      $record = $result->fetch_assoc();
      
      // log in as the new user
      $_SESSION['id'] = $record['user_id'];      
      $_SESSION["you_are_logged_in"] = TRUE;
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $password;

      // give the user some new gear
      $new_user_id = $_SESSION['id'];
      $query = "INSERT INTO user_item (user_id, item_id) VALUES ($new_user_id, 1);";
      $db->query($query);
      $query = "INSERT INTO user_item (user_id, item_id) VALUES ($new_user_id, 2);";
      $db->query($query);
      $query = "INSERT INTO user_item (user_id, item_id) VALUES ($new_user_id, 3);";
      $db->query($query);
      
      // email the user to let them know
      mail ($email, "Welcome to Minimal Adventure!", "Welcome to Minimal Adventure!");      
    
      // now redirect to the welcome page, so the game can begin!
      header("Location: welcome.php");
      die();
    }

    // if the user exists, tell the user to use another username.
    else {
      $errors[] = "That username already exists! Please try another.";
    }
  }
  
  // start setting up the page itself.
  $page_title = "Join";
  include_once ("includes/header.php");

?>
<section>
<?php
  // the create account / join form
  $myForm = '<form method="POST" action="join.php">
  <input type="hidden" name="sent"/>
  <p><label for="username">Username</label> <input type="text" name="username"/></p>
  <p><label for="password">Password</label> <input type="password" name="password"/></p>
  <p><label for="email">Email</label> <input type="text" name="email"/></p>
  <p><input type="submit"/></p>
  </form>
  <p>If you already have an account, you can <a href="login.php">login</a> instead!';
  
  // display any errors that may have cropped up
  foreach ($errors as $e) {
    echo "<p>$e</p>";
  }
  
  echo $myForm;  
?>
</section>
<?php
  include_once ("includes/footer.php");
?>