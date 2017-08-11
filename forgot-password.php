<?php
    include('connection.php');
    // Error message
    $missingEmail = '<p>Please enter your email.</p>';
    $invalidEmail = '<p>Please enter a valid email.</p>';
    // Check user input
    $error = '';
    if(empty($_POST['forgotPasswordEmail'])){
        $error .= $missingEmail;
    }
    else{
        $email = filter_var($_POST["forgotPasswordEmail"],FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $error .= $invalidEmail;
        }
    }
    // Print error message
    if($error){
        $resultMessage = '<div class="alert alert-danger">'.$error.'</div>';
        echo $resultMessage;
        exit;
    }
    $email = mysqli_real_escape_string($link, $email);
    // If email does not exist in the users table print error
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo '<div class="alert alert-danger">Error running the query.</div>';
        echo mysqli_error($link);
        exit;
    }
    $numOfResult = mysqli_num_rows($result);
    if(!$numOfResult){
        echo '<div class="alert alert-danger">The email does not exist. Do you want to register?</div>';
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    // Create a unique activation code
    $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    $time = time();
    $status = 'pending';
    // Insert into forgotpassword table
    $sql = "INSERT INTO forgotpassword (user_id, activation, time, status) VALUES ('$user_id', '$activationKey', '$time', '$status')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo '<div class="alert alert-danger">Error running the query.</div>';
        echo mysqli_error($link);
        exit;
    }
    // Send the user an email with a link to activate the account
    $message = "Please click on this link to reset your password:\n\n";
    $message .="https://simplenotes.000webhostapp.com/resetpassword.php?user_id=" . $user_id . "&key=$activationKey";
    if(mail($email, 'Reset your password', $message, 'From:'.'xiaofeng.qu.83@gmail.com')){
        echo "<div class='alert alert-success'>An email has been sent to $email. Please click on the link to reset your password.</div>";
    }
?>