<?php
  /* This page allows the player to read and leave messages to other players */
  include_once ("includes/session.php");
  include_once('includes/auth.php');
  include_once ("includes/db.php");
  
  // if the user has just submitted an etching, process it.
  if (isset($_GET['action'])) {
    // if the user wants to leave an etching
    if ($_GET['action'] === 'etch') {
      $content = $db->escape_string($_GET['etching']);
      $query = "INSERT INTO etching (etching_content, etching_date) VALUES ('$content', NOW());";
      $db->query ($query);
    }
    
    // if the user wants to remove an entry
    if ($_GET['action'] === 'scratch') {
      $id = $_GET['id'];
      $query = "DELETE FROM etching WHERE etching_id=$id;";
      $db->query ($query);
    }
  }
  
  $page_title = "Restroom";
  include_once ("includes/header.php");
  
?>
<section>
<form method="GET" action="restroom.php">
<p><input type="hidden" name="action" value="etch"></p>
<p><textarea name="etching" rows=10></textarea></p>
<p><input type="submit" value="Etch"/></p>
</form>

<!-- Show previous etchings -->
<h2>Previous Etchings</h2>
<?php
  // default values
  // retrieve 
  $query = "SELECT * FROM etching ORDER BY etching_date DESC;";
  $result = $db->query ($query);
  
  // display as a table
  echo "<table>
  <tr>
  <th>Message</th>
  <th>Date</th>
  <th>Scratch Out?</th></tr>";  
  while ($row = $result->fetch_assoc()) {
    $id = $row['etching_id'];
    $content = $row['etching_content'];
    $date = $row['etching_date'];
    
    echo "<tr>";
    echo "<td>$content</td>";
    echo "<td>$date</td>";
    echo '<td><a href="restroom.php?action=scratch&id=' . $id . '">Remove</a></td>';
    echo "</tr>";
  }
  echo "</table>";
?>
<!-- Pager controls -->

<!-- Leave the restroom -->
<p><a href="inn.php">Return to the Inn</a></p>

</section>
<?php
  include_once ("includes/footer.php");
?>