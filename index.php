<?php
    session_start();
    include('connection.php');
    //logout
    include('logout.php');
    //remember me
    include('remember.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Online Notes</title>
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
                      <li class="active"><a href="#">Home</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                  </ul>
              </div>
          </div>
      </nav>
      
      <!--Jumbotron with sign up button-->
      <div class="jumbotron" id="myContainer">
          <h1>Online Notes App</h1>
          <p>Your notes with you wherever you go.</p>
          <p>Easy to use, protects all your notes!</p>
          <button type="button" class="btn btn-lg orange signup" data-target="#signupModal" data-toggle="modal">Sign up-It's free</button>
      </div>
      
      <!--Sign up modal-->
      <form method="post" novalidate="novalidate" id="signupForm">
          <div class="modal fade" id="signupModal" role="dialog" aria-labelledby="signupModalTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="signupModalTitle">Sign up today and start using our Online Notes App!</h4>
                          </div>
                          <div class="modal-body">
                              <!--Sign up message for PHP file-->
                              <div id="signupMessage"></div>
                              <div class="form-group">
                                  <label for="username" class="sr-only">Username:</label>
                                  <input class="form-control" type="text" id="username" name="username" placeholder="Username" maxlength="30">
                              </div>
                              <div class="form-group">
                                  <label for="email" class="sr-only">Email:</label>
                                  <input class="form-control" type="email" id="email" name="email" placeholder="Email Adress" maxlength="50">
                              </div>
                              <div class="form-group">
                                  <label for="password" class="sr-only">Choose a password:</label>
                                  <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password" maxlength="30">
                              </div>
                              <div class="form-group">
                                  <label for="passwordConfirm" class="sr-only">Confirm the password:</label>
                                  <input class="form-control" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm the password" maxlength="30">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <input class="btn orange" name="signup" type="submit" value="Sign up">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>
      
      <!--Login modal-->
      <form method="post" novalidate="novalidate" id="loginForm">
          <div class="modal fade" id="loginModal" role="dialog" aria-labelledby="loginModalTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="loginModalTitle">Login:</h4>
                      </div>
                      <div class="modal-body">
                          <!-- Login message from PHP file -->
                          <div id="loginMessage"></div>
                          <div class="form-group">
                              <lable for="loginEmail" class="sr-only">Email:</lable>
                              <input class="form-control" type="email" id="loginEmail" name="loginEmail" placeholder="Email address" maxlength="50">
                          </div>
                          <div class="form-group">
                              <lable for="loginPassword" class="sr-only">Password:</lable>
                              <input class="form-control" type="password" id="loginPassword" name="loginPassword" placeholder="Password" maxlength="30">
                          </div>
                          <div class="checkbox">
                              <label>
                                  <input type="checkbox" name="rememberMe" id="rememberMe">
                                  Remember me
                              </label>
                              <a href="#forgotPasswordModal" data-dismiss="modal" data-toggle="modal" class="pull-right" style="cursor: pointer">Forgot Password?</a>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                          <input type="submit" name="login" class="btn orange" value="Login">
                          <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                      </div>
                  </div>            
              </div>
          </div>
      </form>
      <!-- Forgot password form -->
      <form method="post" novalidate="novalidate" id="forgotPasswordForm">
          <div class="modal fade" id="forgotPasswordModal" name="forgotPasswordModal" role="dialog" aria-labelledby="forgotPasswordTitle" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title" id="forgotPasswordTitle">Forgot password? Enter your email address:</h4>
                      </div>
                      <div class="modal-body">
                          <!-- Forgot password message from PHP file -->
                          <div id="forgotPasswordMessage"></div>
                          <div class="form-group">
                              <label for="forgotPasswordEmail" class="sr-only">Email:</label>
                              <input type="email" class="form-control" name="forgotPasswordEmail" id="forgotPasswordEmail" placeholder="Email" maxlength="50">
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
                          <input type="submit" name="forgotPassword" class="btn orange" value="Submit">
                          <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
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
      <script src="js/index.js"></script>
  </body>
</html>