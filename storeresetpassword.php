<?php
    // Connect database
    include('connection.php');
    // Receive variables
    $user_id = filter_var($_POST['reset_user_id'], FILTER_SANITIZE_STRING);
    $key = filter_var($_POST['reset_key'], FILTER_SANITIZE_STRING);
    $newPassword = $_POST['newPassword'];
    $newPasswordConfirm = $_POST['newPasswordConfirm'];
    // Define error message
    $missingNewPassword = '<p>Please enter your new password.';
    $invalidNewPassword = '<p>Your password should be at least 6 characters long and include at least one capital letter and one number!</p>';
    $missingNewPasswordConfirm = '<p>Please confirm your new password.';
    $passwordsNotMatch = '<p>Passwords do not match.';
    $errors = '';
    if(empty($newPassword)){
        $errors .= $missingNewPassword;
    }
    elseif(strlen($newPassword)<6 or !preg_match('/[A-Z]/', $newPassword) or !preg_match('/[0-9]/', $newPassword)){
        $errors .= $invalidNewPassword;
    }
    else{
        $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
        if(empty($newPasswordConfirm)){
            $errors .= $missingNewPasswordConfirm;
        }
        else{
            $newPasswordConfirm = filter_var($newPasswordConfirm, FILTER_SANITIZE_STRING);
            if($newPassword !== $newPasswordConfirm){
            $errors .= $passwordsNotMatch;
            }
        }
    }
    
    if($errors){
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
        exit;
    }

    $user_id = mysqli_real_escape_string($link, $user_id);
    $key = mysqli_real_escape_string($link, $key);
    $newPassword = mysqli_real_escape_string($link, $newPassword);
    $newPassword = hash('sha256', $newPassword);
    $sql = "UPDATE users SET password = '$newPassword' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
    }
    $sql = "UPDATE forgotpassword SET status = 'used' WHERE user_id = '$user_id' AND activation = '$key'";
    $result = mysqli_query($link, $sql);
    if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
    }
    echo "success";
?>