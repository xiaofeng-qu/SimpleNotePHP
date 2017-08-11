$(function(){
    // define variables
    var activeNote = 0;
    var editMode = false;
    // load notes on page load: Ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function(data){
            $('#notes').html(data);
            clickOnNote();
            clickDelete();
        },
        error: function(){
            $('#alertContent').text("There was an issue loading the notes from the database! Please try again later.");
            $('#alert').fadeIn();
        }
    });
    
    // add a new note
    $('#addNote').click(function(){
        $.ajax({
            url: "createnote.php",
            success: function(data){
                if(data == "error"){
                    $('#alertContent').text("There was an issue inserting the new note in the database!");
                    $('#alert').fadeIn();
                }
                else{
                    // update active note to the id of the new note
                    activeNote = data;
                    $('#notePadTextarea').val("");
                    // show hide elements
                    showHide(['#notePad', '#allNotes'], ['#notes', '#addNote', '#edit', '#done']);
                    $('#notePadTextarea').focus();
                }
            },
            error: function(){
                $('#alertContent').text("There was an issue inserting into the database! Please try again later.");
                $('#alert').fadeIn();
            }
        });
    });
    
    
    // type note: Ajax call to updatenote.php
    $("#notePadTextarea").keyup(function(){
        updateNote();        
    });
    
    // click on all notes button
    $('#allNotes').click(function(){
        $.ajax({
            url: "loadnotes.php",
            success: function(data){
                $('#notes').html(data);
                showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad", "#done"]);
                clickOnNote();
                clickDelete();
            },
            error: function(){
                $('#alertContent').text("There was an issue loading the notes from the database! Please try again later.");
                $('#alert').fadeIn();
            }
        });
    });
    
    // click on done button
    $('#done').click(function(){
        editMode = false;
        $('.well').removeClass("col-xs-7 col-sm-9");
        // Show hide elements
        showHide(["#edit"],[".delete", this]);
    });
    // edit button
    $('#edit').click(function(){
        editMode = true;
        // Add classes to notes
        $('.well').addClass("col-xs-7 col-sm-9");
        // Show hide elements
        showHide(["#done", ".delete"], [this]);
    });
    
    // Speech input
    $('#speechInput').click(function(){
        if(window.hasOwnProperty('webkitSpeechRecognition')){
            var recognition = new webkitSpeechRecognition();
            
            recognition.continuous = false;
            recognition.interimResults = false;
            
            recognition.lang = "en-US";
            recognition.start();
            
            recognition.onresult = function(e){
                $("#notePadTextarea").val($("#notePadTextarea").val() + e.results[0][0].transcript);
                recognition.stop();
                updateNote();
            }
            recognition.onerror = function(e) {
                recognition.stop();
            }
        }
    });
    
    // delete button
    function clickDelete(){
        $('.delete').click(function(){
            var deleteButton = $(this);
            $.ajax({
                url: "deletenote.php",
                type: "POST",
                data: {id: deleteButton.next().attr('id')},
                success: function(data){
                    if(data == "error"){
                        $('#alertContent').text("There was an issue updating the note into the database! Please try again later.");
                        $('#alert').fadeIn();
                    }
                    else{
                        deleteButton.parent().remove();
                    }
                },
                error: function(){
                    $('#alertContent').text("There was an issue deleting the note from the database! Please try again later.");
                    $('#alert').fadeIn();
                }
            });
        });
    }
    
    // click the note
    function clickOnNote(){
        $(".well").click(function(){
            if(!editMode){
                // collect active note id
                activeNote = $(this).attr("id");
                // fill the textarea
                $("#notePadTextarea").val($(this).find(".text").text());
                showHide(['#notePad', '#allNotes'], ['#notes', '#addNote', '#edit', '#done']);
                $('#notePadTextarea').focus();
            }
        });
    }
    
    // Show hide elements
    function showHide(array1, array2){
        for(i = 0; i < array1.length; i++){
            $(array1[i]).show();
        }
        for(i = 0; i < array2.length; i++){
            $(array2[i]).hide();
        }
    }
    
    // Function to update notes
    function updateNote(){
        var theTextarea = $('#notePadTextarea');
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            data: {note: theTextarea.val(), id: activeNote},
            success: function(data){
                if(data == "error"){
                    $('#alertContent').text("There was an issue updating the note into the database! Please try again later.");
                    $('#alert').fadeIn();
                }
            },
            error: function(){
                $('#alertContent').text(activeNotes);
                $('#alert').fadeIn();
            }
        });
    }
    
});
