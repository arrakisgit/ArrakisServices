<?php
echo "<form action='http://192.168.0.23/ArrakisServices/ArrakisServices/controllers/SendMediaFiles.php' method='POST' enctype='multipart/form-data'>";;
echo "<p>Images:";
echo "<input type='file' name='userfile' />";
echo "<input type='submit' value='Send' />";
echo "</p>";
echo "</form>";
?>