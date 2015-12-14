<?php 
  /* This page allows the player to log in to the game. */
  
  include_once ("includes/session.php");
  include_once ("includes/db.php");
  
  // there will probably be errors.
  $errors = [];
  
  // if the user is not logged in to the session, but has just sent the login form, we authenticate here.
  if (!isset($_SESSION["you_are_logged_in"]) && isset($_POST["sent"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // check if the sent username and password are in the database    
    $query = "SELECT * FROM user WHERE user_name = '" . $db->escape_string($username) . "';";
    $result = $db->query ($query);
    
    // if a user with this username exists...
    if ($result->num_rows > 0) {
      
      // retrieve the record (there should never be more than one in the database)
      $record = $result->fetch_assoc();
      
      // verify the password for the first one (there should never be more than one in the database)                 
      if (password_verify($password, $record['user_password'])) {
        // log us in!
        $_SESSION['id'] = $record['user_id'];
        $_SESSION["you_are_logged_in"] = TRUE;
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
            
        header("Location: map.php");
        die();
      }
      else {
        $errors[] = "Cannot log in! Are you sure you provided the correct username and password?";
      }
    }
    else {
      $errors[] = "Cannot log in! Are you sure you provided the correct username and password?";
    }
  }
  
  $page_title = "Login";
  include_once ("includes/header.php");
?>
<section>
<?php
  // if the user is logged in, suggest that the user log out first.
  if (isset($_SESSION["you_are_logged_in"])) {
    echo '<p>You are already logged in. Would you like to <a href="logout.php">Log out</a>, or maybe visit the <a href="map.php">map</a>?</p>';
  }
  
  // if the user is logged out,
  else { 
    // the login form
    $myForm =
    '<form action="login.php" method="POST">
    <input type="hidden" name="sent"/>
    <p><label for="username">Username</label> <input type="text" name="username"/></p>
    <p><label for="password">Password</label> <input type="password" name="password"/></p>
    <p><input type="submit" value="Login"/></p>
    </form>
    <p>If you do not have an account yet, you can create a <a href="join.php">new account</a> here.</p>';

    // show any errors
    foreach ($errors as $e) {
      echo "<p>$e</p>";
    }
    
    // show the form
    echo $myForm;
  }   
?>
</section>
<?php
  include_once ("includes/footer.php");
?>