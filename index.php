<?php
  /* This page welcomes the user and displays a visitor counter. */
  
  // keep a counter of visits on this page
  function visitor_counter () {    
    $filename = "counter.txt";
    if (file_exists($filename)) {
      $counter = file_get_contents($filename);
      $counter++;
    } else {
      $counter = 1;
    }
    file_put_contents($filename, $counter);
    return $counter;
  }
  
  $page_title = "Entrance";
  include_once ("includes/header.php");
?>
<section>
<a href="login.php"><img src="images/enter.png" alt="Entrance"/></a>
<p>Welcome to <strong>Minimal Adventure!</strong> This game was made with PHP, HTML5, CSS, and MySQL as a final for <strong>ITC 240: Web Apps I</strong>.</p>
<p>It is modeled after old adventure games such as <em>Legend of the Red Dragon</em> although, in the interest of making it in a single week, this game is deliberately simple.</p>
<p>As this is not a commercial endeavor, it is entirely free to play, so join now! <strong>Minimal Adventure Awaits!</strong></p>
<p><em><?php echo visitor_counter(); ?> adventurers have visited this page!</em></p>
<ul>
  <li><a href="login.php">Login</a></li>
  <li><a href="join.php">Join</a></li>
</ul>
</section>
<?php
  include_once ("includes/footer.php");
?>