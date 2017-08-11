<?php
    // If the user is not logged in & rememberme cookie exists
    if(isset($_SESSION['user_id']) AND !empty($_COOKIE['rememberme'])){
        // array_key_exists('user_id', $_SESSION)
        // extract $authentificator 1 & 2 from the cookie
        list($authentificator1, $authentificator2) = explode(',', $_COOKIE['rememberme']);
        $authentificator2 = hex2bin($authentificator2);
        $f2authentificator2 = hash('sha256', $authentificator2);
        $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
        $result = mysqli_query($link, $sql);
        if(!$result){
            echo '<div class="alert alert-danger">There was an error running the query.</div>';
            exit;
        }
        $count = mysqli_num_rows($result);
        if($count !== 1){
            echo '<div class="alert alert-danger">Rememebr me process failed!</div>';
            exit;
        }
        $row = mysqli_fetch_assoc($result);
        if(!hash_equals($row['f2authentificator2'],$f2authentificator2)){
            echo '<div class="alert alert-danger">hash_equals returned false.</div>';
        }
        else{
            $_SESSION['user_id'] = $row['user_id'];
            $user_id = $row['user_id'];
            $expiration = $row['expires'];
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
                strtotime($expiration)
            );
            function f2($a){
                return hash('sha256', $a);
            }
            $f2authentificator2 = f2($authentificator2);
            // Run query to store them in rememberme table
            $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires) VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
            $result = mysqli_query($link, $sql);
            if(!$result){
                echo '<div class="alert alert-danger">Error running the query!</div>';
                echo mysqli_error($link);
                exit;
            }
            else{
                $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($link, $sql);

                if(!$result){
                echo '<div class="alert alert-danger">Error running the query!</div>';
                echo mysqli_error($link);
                exit;
                }
                else{
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    header('location: mainpageloggedin.php');
                }
            }
        }
    }

    if(isset($_SESSION['username'])){
        header('location: mainpageloggedin.php');
    }
?>