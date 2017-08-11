<?php
    // Connect to the database
    $link = mysqli_connect("localhost", "simplenotes", "hchnpwlXS8wKrq6T", "simplenotes");
    if(mysqli_connect_error()){
        die("ERROR: Unable to connect：".mysqli_connect_error());
    }
?>