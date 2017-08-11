<?php
    // Start session
    session_start();
    // Connect to the database
    include('connection.php');
    // Check user inputs
    // Define error messages
    $missingEmail = "<p>Please enter your email address.</p>";
    $missingPassword = "<p>Please enter your password.</p>";
    $errors = "";
    // Get email and password
    $email = $_POST['loginEmail'];
    if(empty($email)){
        $errors .= $missingEmail;
    }
    else{
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    $password = $_POST['loginPassword'];
    if(empty($password)){
        $errors .= $missingPassword;
    }
    else{
        $password = filter_var($password, FILTER_SANITIZE_STRING);
    }
    // If there are any errors
    if($errors){
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
    }
    else{
         // Prepare variables for the queries
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        $password = hash('sha256', $password);
        // Query
        $sql = "SELECT * from users WHERE email = '$email' AND password = '$password' AND activation = 'activated'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">Error running the query!</div>';
            exit;
        }
        // If email & password don't match print error
        $count = mysqli_num_rows($result);
        if($count !== 1){
            echo '<div class="alert alert-danger">Wrong username or password</div>';
        }
        else{
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            
            if(empty($_POST['rememberMe'])){
                echo "success";
            }
            else{
                // Create two variables $authentificator1 and $authentificator2
                $authentificator1 = openssl_random_pseudo_bytes(10);
                $authentificator2 = openssl_random_pseudo_bytes(20);
                // Store them in a cookie
                function f1($a, $b){
                    $c = $a . "," . bin2hex($b);
                    return $c;
                }
                $cookieValue = f1($authentificator1, $authentificator2);
                setcookie(
                    "rememberme",
                    $cookieValue,
                    time() + 1296000
                );
                function f2($a){
                    return hash('sha256', $a);
                }
                $f2authentificator2 = f2($authentificator2);
                $user_id = $_SESSION['user_id'];
                $expiration = date('Y-m-d H:i:s', time() + 1296000);
                // Run query to store them in rememberme table
                $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires) VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
                $result = mysqli_query($link, $sql);
                if(!$result){
                    echo '<div class="alert alert-danger">Error running the query!</div>';
                    // echo mysqli_error($link);
                    exit;
                }
                else{
                    echo "success";
                }
            }
        }
    }
?>