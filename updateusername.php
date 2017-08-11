<?php
    session_start();
    // connect to database
    include('connection.php');
    // define error message
    $missingUsername = "<p>Please enter your username!</p>";
    // get username
    $error = "";
    if(empty($_POST['updateUsername'])){
        $error = $missingUsername;
    }
    else{
        $username = filter_var($_POST['updateUsername'], FILTER_SANITIZE_STRING);
    }

    if($error){
        $resultMessage = '<div class="alert alert-danger">' . $error . '</div>';
        echo $resultMessage;
    }
    else{
        $username = mysqli_real_escape_string($link, $username);
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE users SET username = '$username' WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">Cannot conduct the query.</div>';
        }
        else{
            $_SESSION['username'] = $username;
        }
    }
?>