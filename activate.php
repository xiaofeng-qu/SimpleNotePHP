<?php
    // The user is re-directed to this file after clicking the activation link
    session_start();
    include('connection.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Account Activate</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- Customized style -->
        <link href="css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  </head>
  <body>
      <div class="container" style="margin-top:100px">
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                <h2 style="background-color:rgba(255,255,255,.4); padding-left:10px;">Account Activation</h2>
                <?php
                    // If email or activation key is missing show an error
                    if(!isset($_GET['email']) or !isset($_GET['key'])){
                        echo '<div class="alert alert-danger">There was an error. Please click on the activation link you received.</div>';
                        exit;
                    }
                    else{
                        $email = $_GET['email'];
                        $key = $_GET['key'];
                        $email = mysqli_real_escape_string($link, $email);
                        $key = mysqli_real_escape_string($link, $key);
                        $sql = "UPDATE users SET activation = 'activated' WHERE (email = '$email' AND activation = '$key') LIMIT 1";
                        $result = mysqli_query($link, $sql);
                        if(!$result){
                            echo '<div class="alert alert-danger">Error running the query.</div>';
                            echo mysqli_error($link);
                            exit;
                        }
                        if(mysqli_affected_rows($link) == 1){
                            echo '<div class="alert alert-success">Your account has been activated.</div>';
                            echo '<a href="index.php" type="button" class="btn btn-lg btn-success">Log in</a>';
                        }
                        else{
                            $sql = "SELECT activation FROM users WHERE email = '$email'";
                            $result = mysqli_query($link, $sql);
                            $row = mysqli_fetch_assoc($result);
                            if($row['activation'] === "activated"){
                                echo '<div class="alert alert-danger">Your account has already been activated.</div>';
                                echo '<a href="index.php" type="button" class="btn btn-lg btn-success">Log in</a>';
                            }
                            else{
                                echo '<div class="alert alert-danger">Your account cannot be activated, please try again later.</div>';
                            exit;
                            }
                        }
                    }
                ?>
              </div>
          </div>
      </div>
      <!--Footer-->
      <div class="footer">
          <div class="container">
              <p>Xiaofeng Copyright &copy; 2017-<?php echo date("Y")?>.</p>
          </div>
      </div>

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="js/bootstrap.min.js"></script>
  </body>
</html>