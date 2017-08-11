// Ajax call for the sign up form
// Once the form is submitted
$("#signupForm").submit( function(event) {
    // prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    // send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupMessage").html(data);
            }
        },
        error: function(){
            $("#signupMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});

// Ajax call for the log in form
// Once the form is submitted
$("#loginForm").submit( function(event) {
    // prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    // send them to login.php using AJAX
    $.ajax({
        url: "login.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
                window.location = "mainpageloggedin.php";
            }
            else{
                $("#loginMessage").html(data);
            }
        },
        error: function(){
            $("#loginMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});

// Ajax call for the forgot password form
// Once the form is submitted
$("#forgotPasswordForm").submit( function(event) {
    // prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    // send them to login.php using AJAX
    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#forgotPasswordMessage").html(data);
            }
        },
        error: function(){
            $("#signupMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});
    