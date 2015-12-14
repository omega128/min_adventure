<?php
  /* This page allows the player to change their password, or delete their account entirely.*/
  include_once ("includes/session.php");
  include_once ("includes/auth.php");
  include_once ("includes/db.php");
  
  // this page will give user feedback.
  $feedback = [];
  
  // is the user trying to change their password?
  if (isset($_POST['change_password'])) {
    if ($_POST['password'] === $_POST['again']) {
      
      // reset the user's password
      $query = "UPDATE user SET user_password = '" . $db->escape_string(password_hash($_SESSION['password'], PASSWORD_DEFAULT)) . "' WHERE user_name = '" . $db->escape_string($_SESSION['username']) . "';";
      $db->query ($query);
      $feedback[] = "New password set!";
    }
    else
    {
      $feedback[] = "Passwords do not match!";
    }
  }
  
  // is the user trying to delete their account?
  if (isset($_POST['delete_account'])) {
    if ($_POST['absolutely_sure'] === 'yes') {
      // delete the user account
      $query = "DELETE FROM user WHERE user_name='" . $_SESSION['username'] . "';";
      $db->query ($query);
      
      // delete all this user's inventory.
      $query = "DELETE FROM user_item WHERE user_id=" . $_SESSION['id'] . ";";
      $db->query ($query);
      
      // log out for the last time
      $db->close();
      session_unset();
      session_destroy();
      
      // redirect to the goodbye page
      header ("Location: goodbye.php");
      die();
    }
  }
  
  $page_title = "Account";
  include_once ("includes/header.php");
?>
<section>
<p>This is where you can make changes to your account, such as changing your password, or even deleting the whole thing.</p>
<p>You are logged in as <strong><?php echo $_SESSION['username']; ?></strong></p>
<h2>Change Password</h2>
<?php
  // list any messages from the last action
  foreach ($feedback as $f) {
    echo "<p>$f</p>";
  }
?>
<form method="POST" action="account.php">
<input type="hidden" name="change_password">
<p><label>New Password</label> <input type="password" name="password"/></p>
<p><label>Again</label> <input type="password" name="again"/></p>
<p><input type="submit" value="Change Password"></p>
</form>

<h2>Delete Account</h2>
<form method="post" action="account.php">
<input type="hidden" name="delete_account">
<p><input type="checkbox" name="absolutely_sure" value="yes">Yes, I am absolutely, positively sure, please delete my account.</input></p>
<p><input type="submit" value="Delete Account"></p>
</form>

</section>
<?php
  include_once ("includes/footer.php");
?>