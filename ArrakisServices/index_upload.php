<?php
echo "<form action='http://192.168.0.23/ArrakisServices/ArrakisServices/controllers/SendMediaFiles.php' method='POST' enctype='multipart/form-data'>";
echo "<p>Files:<br/>";
echo "<input type='file' name='userfile' /><br/>";
echo "<input type='submit' value='Send' /><br/>";
echo "</p>";
echo "</form>";
?>