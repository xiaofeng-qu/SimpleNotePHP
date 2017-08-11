<?php
    session_start();
    include('connection.php');

    // Get the id of the note
    $id = $_POST['id'];
    $note = $_POST['note'];
    $note = mysqli_real_escape_string($link, $note);
    $time = time();
    // Get the content of the note
    $sql = "UPDATE notes SET note = '$note', time = '$time' WHERE id = '$id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "error";
        exit;
    }
?>