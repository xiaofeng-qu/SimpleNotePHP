<?php
    session_start();
    // connect to database
    include('connection.php');
    // define error message
    $missingEmail = "<p>Please enter your email!</p>";
    $invalidEmail = '<p>Please enter a valid email address!</p>';
    $emailExist = '<p>The email already exists. Do you want to login? <a href="index.php">[login]</a></p>';
    // get email
    $error = "";
    if(empty($_POST['updateEmail'])){
        $error = $missingEmail;
    }
    else{
        $email = filter_var($_POST['updateEmail'], FILTER_SANITIZE_STRING);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = $invalidEmail;
        }
    }
    
    $email = mysqli_real_escape_string($link, $email);
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo '<div class="alert alert-danger">Cannot conduct the query.</div>';
        exit;
    }
    $numOfResult = mysqli_num_rows($result);
    if($numOfResult == 1){
        $error = $emailExist;
    }
    if($error){
        $resultMessage = '<div class="alert alert-danger">' . $error . '</div>';
        echo $resultMessage;
    }
    else{
        $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
        $sql = "UPDATE users SET email = '$email', activation = '$activationKey' WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">Cannot conduct the query.</div>';
        }
        else{
            $oldEmail = $_SESSION['email']; 
            // Send the user an email with a link to activate the account
            $message = "Please click on this link to reactivate your account:\n\n";
            $message .= "https://simplenotes.000webhostapp.com/activate.php?email=" . urlencode($email) . "&key=$activationKey";
            $messageToOldEmail = "Your email is just changed to " . $email . ". Please contact us immediately if you did not change it.";
            if(mail($email, 'Confirm your email', $message, 'From:'.'xiaofeng.qu.83@gmail.com') 
            AND 
            mail($oldEmail, 'Your email is just changed', $messageToOldEmail, 'From:'.'xiaofeng.qu.83@gmail.com')){
                echo "<div class='alert alert-success'>You email has been successfully changed. A confirmation email has been sent to $email. Please click on the activation link to reactivate your account.</div>";
                session_destroy();
                setcookie(
                    "rememberme",
                    "",
                    time() - 3600
                );
            }
        }
    }
?>