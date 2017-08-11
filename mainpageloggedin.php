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
        <title>My Notes</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <!-- Customized style -->
        <link href="css/style.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <style>
            .delete{
                display: none;
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
                      <li><a href="profile.php">Profile</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      <li class="active"><a href="mainpageloggedin.php">My notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="profile.php">Logged in as <b><?php echo $_SESSION['username'];?></b></a></li>
                      <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              </div>
          </div>
      </nav>
      
      <!-- Container -->
      <div class="container" style="margin-top:100px">
          <div id="alert" class="alert alert-danger collapse">
              <a class="close" data-dismiss="alert">&times;</a>
              <p id="alertContent"></p>
          </div>
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <div class="marginBottom20">
                      <button type="button" id="addNote" class="btn btn-info btn-lg">Add Note</button>
                      <button type="button" id="allNotes" class="btn btn-info btn-lg" style="display:none;">All Notes</button>
                      <button type="button" id="edit" class="btn btn-info btn-lg pull-right">Edit</button>
                      <button type="button" id="done" class="btn green btn-lg pull-right" style="display:none;">Done</button>
                  </div>
                  <div>
                      <div id="notePad" class="input-group" style="display:none;">
                          <span id="speechInput" class="input-group-addon btn btn-default">
                              <i class="fa fa-microphone"></i>
                          </span>
                          <textarea id="notePadTextarea" class="form-control" rows="10"></textarea>
                      </div>
                  </div>
                  <div>
                      <div id="notes" class="notes">
                      </div>
                  </div>
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
      <script src="js/mynotes.js"></script>
  </body>
</html>