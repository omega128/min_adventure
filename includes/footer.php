<?php
  // close any open connections when we get to the end of the document
  if (isset($db)) {
    $db->close();
  }
?>
</section>

<!-- include some copyright information at the bottom -->
<footer><p>Copyright &copy; 2015 Kristopher Chambers</p></footer>
</div>
</body>
</html>