<?php
    session_start();
    include('connection.php');

    // Get the id of the note
    $id = $_POST['id'];
    // Run a query to delete the note
    $sql = "DELETE FROM notes WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "error";
        exit;
    }
?>