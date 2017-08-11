// Ajax for updateUsernameForm
$('#updateUsernameForm').submit(function(event){
    // prevent default php processing
    event.preventDefault();
    // collect user input
    var datatopost = $(this).serializeArray();
    // send the input to updateusername.php using AJAX
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateUsernameMessage").html(data);
            }
            else{
                location.reload();
            }
        },
        error: function(){
            $("#updateUsernameMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});

// Ajax for updateEmailForm
$("#updateEmailForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updateEmailMessage").html(data);
            }
            else{
                location.reload();
            }
        },
        error: function(){
            $("#updateEmailMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});

// Ajax for updatePasswordForm
$("#updatePasswordForm").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#updatePasswordMessage").html(data);
            }
        },
        error: function(){
            $("#updateEmailMessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    });
});