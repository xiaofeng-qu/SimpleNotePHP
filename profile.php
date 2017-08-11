<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Profile</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- Customized style -->
        <link href="css/style.css" rel="stylesheet">
        <style>
            tr{
                cursor: pointer;
                color: black;
                background-color: rgba(255,255,255,.4);
            }
        </style>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  </head>
  <body>
      <!--Navigation Bar-->
      <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a href="index.php" class="navbar-brand">Online Notes</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle Navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                      <li class="active"><a href="profile.php">Profile</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      <li><a href="mainpageloggedin.php">My notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="profile.php">Logged in as <?php echo $_SESSION['username'];?></a></li>
                      <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              </div>
          </div>
      </nav>
      
      <!-- Container -->
      <div class="container" style="margin-top:100px">
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <h2 style="background-color:rgba(255,255,255,.4); padding-left:10px;">General Account Settings:</h2>
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed table-bordered">
                          <tr data-target="#updateUsernameModal" data-toggle="modal">
                              <td width="20%">Username:</td>
                              <td><?php echo $_SESSION['username'];?></td>
                          </tr>
                          <tr data-target="#updateEmailModal" data-toggle="modal">
                              <td>Email:</td>
                              <td><?php echo $_SESSION['email'];?></td>
                          </tr>
                          <tr data-target="#updatePasswordModal" data-toggle="modal">
                              <td>Password:</td>
                              <td>hided</td>
                          </tr>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      
      <!--Update username modal-->
      <form method="post" id="updateUsernameForm">
          <div class="modal fade" id="updateUsernameModal" role="dialog" aria-labelledby="updateUsernameModalTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="updateUsernameModalTitle">Update username:</h4>
                          </div>
                          <div class="modal-body">
                              <!--Update unsername message for PHP file-->
                              <div id="updateUsernameMessage"></div>
                              <div class="form-group">
                                  <label for="updateUsername">Username:</label>
                                  <input class="form-control" type="text" id="updateUsername" name="updateUsername" value="<?php echo $_SESSION['username'];?>" maxlength="30">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <input class="btn orange" name="update" type="submit" value="Update">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>
      
      <!-- Update email form -->
      <form method="post" id="updateEmailForm" novalidate="NOVALIDATE">
          <div class="modal fade" id="updateEmailModal" name="updateEmailModal" role="dialog" aria-labelledby="updateEmailTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="updateEmailTitle">Update email:</h4>
                      </div>
                      <div class="modal-body">
                          <!-- Update email message from PHP file -->
                          <div id="updateEmailMessage"></div>
                          <div class="form-group">
                              <label for="updateEmail">Email:</label>
                              <input type="email" class="form-control" name="updateEmail" id="updateEmail" value="<?php echo $_SESSION['email'];?>" maxlength="50">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" name="updateEmailButton" class="btn orange" value="Update">
                          <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                      </div>
                  </div>
              </div>
          </div>
      </form>
      
      <!--Update password modal-->
      <form method="post" id="updatePasswordForm">
          <div class="modal fade" id="updatePasswordModal" role="dialog" aria-labelledby="updatePasswordModalTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="updatePasswordModalTitle">Update password:</h4>
                      </div>
                      <div class="modal-body">
                              <!--Update password message for PHP file-->
                              <div id="updatePasswordMessage"></div>
                              <div class="form-group">
                                  <label for="currentPassword" class="sr-only">Current Password:</label>
                                  <input class="form-control" type="password" id="currentPassword" name="currentPassword" placeholder="Your current password" maxlength="30">
                              </div>
                              <div class="form-group">
                                  <label for="newPassword" class="sr-only">Choose a password:</label>
                                  <input class="form-control" type="password" id="newPassword" name="newPassword" placeholder="Choose a password" maxlength="30">
                              </div>
                              <div class="form-group">
                                  <label for="confirmNewPassword" class="sr-only">Confirm your password:</label>
                                  <input class="form-control" type="password" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm your password" maxlength="30">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <input class="btn orange" name="updatePasswordButton" type="submit" value="Update">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                  </div>            
              </div>
          </div>
      </form>
      
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
      <script src="js/profile.js"></script>
  </body>
</html>