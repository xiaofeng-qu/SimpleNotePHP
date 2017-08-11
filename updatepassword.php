<?php
    session_start();
    include('connection.php');
    // Define error message
    $missingCurrentPassword = "<p>Please enter your current password!</p>";
    $wrongCurrentPassword = "<p>You enter the wrong current password!</p>";
    $missingNewPassword = "<p>Please enter your new password!</p>";
    $missingNewPasswordConfirm = "<p>Please confirm your new password!</p>";
    $passwordsNotMatch = "<p>Password do not match!";
    $invalidPassword = "<p>Your password should be at least 6 characters long and include at least one capital letter and one number!</p>";
    // Collect error
    $errors = "";
    if(empty($_POST['currentPassword'])){
        $errors .= $missingCurrentPassword;
    }
    else{
        $currentPassword = filter_var($_POST['currentPassword'], FILTER_SANITIZE_STRING);
        $currentPassword = hash('sha256', $currentPassword);
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND password ='$currentPassword'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
        }
        $numOfResult = mysqli_num_rows($result);
        if($numOfResult !== 1){
            $errors .= $wrongCurrentPassword;
        }
    }
    
    if(empty($_POST['newPassword'])){
        $errors .= $missingNewPassword;
    }
    elseif(strlen($_POST["newPassword"])<6 or !preg_match('/[A-Z]/', $_POST["newPassword"]) or !preg_match('/[0-9]/', $_POST["newPassword"])){
        $errors .= $invalidPassword;
    }
    else{
        if(empty($_POST['confirmNewPassword'])){
            $errors .= $missingNewPasswordConfirm;
        }
        else{
            $newPassword = filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING);
            $confirmNewPassword = filter_var($_POST['confirmNewPassword'], FILTER_SANITIZE_STRING);
            if($newPassword !== $confirmNewPassword){
                $errors .= $passwordsNotMatch;
            }
        }
    }
    
    if($errors){
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
    }
    else{
        $newPassword = filter_var($_POST['newPassword'], FILTER_SANITIZE_STRING);
        $newPassword = hash('sha256', $newPassword);
        $newPassword = mysqli_real_escape_string($link, $newPassword);
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE users SET password = '$newPassword' WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
        }
        echo '<div class="alert alert-success">Your password has been updated. Please login with your new password. <a href="index.php">[login]</a></div>';
        session_destroy();
        setcookie(
            "rememberme",
            "",
            time() - 3600
        );
    }
?>