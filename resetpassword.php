<?php
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
                <h2 style="background-color:rgba(255,255,255,.4); padding-left:10px;">Reset Password</h2>
                <?php
                    // If email or activation key is missing show an error
                    if(!isset($_GET['user_id']) or !isset($_GET['key'])){
                        echo '<div class="alert alert-danger">There was an error. Please click on the reset password link you received.</div>';
                        exit;
                    }
                    else{
                        // Store them in two variables
                        $user_id = $_GET['user_id'];
                        $key = $_GET['key'];
                        // Prepare them for the query
                        $user_id = mysqli_real_escape_string($link, $user_id);
                        $key = mysqli_real_escape_string($link, $key);
                        $time = time() - 86400;
                        // Run query: check combination of user_id & key exists and less than 24h old
                        $sql = "SELECT * FROM forgotpassword WHERE user_id = '$user_id' AND activation = '$key'";
                        $result = mysqli_query($link, $sql);
                        if(!$result){
                            echo '<div class="alert alert-danger">Error running the query.</div>';
                            echo mysqli_error($link);
                            exit;
                        }
                        // If combination does not exist show an error message
                        $numOfResult = mysqli_num_rows($result);
                        if($numOfResult !== 1){
                            echo '<div class="alert alert-danger">Please try again. <a href="index.php">[go back]</a></div>';
                            exit;
                        }
                        $row = mysqli_fetch_assoc($result);
                        if($row['time'] < $time){
                            echo '<div class="alert alert-danger">Your reset key is outdated. Please try the forgot password process again. <a href="index.php">[go back]</a></div>';
                            exit;
                        }
                        if($row['status'] == "used"){
                            echo '<div class="alert alert-danger">Your reset key is used. Please try the forgot password process again. <a href="index.php">[go back]</a></div>';
                            exit;
                        }
                ?>
                        <div id="resetPassword">
                            <form method="post" novalidate="novalidate" id="resetPasswordForm">
                                  <!--reset password message for PHP file-->
                                  <div id="resetPasswordMessage"></div>
                                  <div class="form-group">
                                      <label for="newPassword" class="sr-only">Choose a new password:</label>
                                      <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="Choose a new password" maxlength="30">
                                  </div>
                                  <div class="form-group">
                                      <label for="newPasswordConfirm" class="sr-only">Confirm the password:</label>
                                      <input class="form-control" type="password" id="newPasswordConfirm" name="newPasswordConfirm" placeholder="Confirm the password" maxlength="30">
                                  </div>
                                  <input type="hidden" name="reset_user_id" id="reset_user_id" value="<?php echo $user_id;?>">
                                  <input type="hidden" name="reset_key" id="reset_key" value="<?php echo $key;?>">
                                  <input type="submit" class="btn orange" name="resetPassword" value="Reset Password">
                            </form>
                        </div>
                <?php
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
      <script>
          $("#resetPasswordForm").submit(function(event){
              event.preventDefault();
              datatopost = $(this).serializeArray();
              console.log(datatopost);
              $.ajax({
                  url: "storeresetpassword.php",
                  type: "POST",
                  data: datatopost,
                  success: function(data){
                      if(data == "success"){
                          $("#resetPassword").html("<div class='alert alert-success'>Your password has been reset.</div><a href='index.php' type='button' class='btn btn-lg btn-success'>Log in</a>");
                      }
                      else{
                          $("#resetPasswordMessage").html(data);
                      }
                  },
                  error: function(){
                      $("#resetPasswordMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
                  }
              });
          });
      </script>
  </body>
</html>