<?php
    session_start();
    include('connection.php');
    
    // Get the user_id
    $user_id = $_SESSION['user_id'];
    // Run a query to delete empty notes
    $sql = "DELETE FROM notes WHERE note=''";
    $result = mysqli_query($link, $sql);
    if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
    }
    // Run a query to look for notes corresponding to user_id
    $sql = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY time DESC";
    $result = mysqli_query($link, $sql);
    if(!$result){
            echo '<div class="alert alert-danger">Error running the query.</div>';
            echo mysqli_error($link);
            exit;
    }
    $numOfResult = mysqli_num_rows($result);
    if($numOfResult == 0){
        echo '<div class="well">There is no note. Create your first note.</div>';
    }
    else{
        while($row = mysqli_fetch_assoc($result)){
            $note = $row['note'];
            $time = date('Y/m/d H:i:s A', $row['time']);
            $note_id = $row['id'];
            echo "
            <div class='note'>
            <div class='col-xs-5 col-sm-3 delete'>
            <button class='btn btn-lg btn-danger' style='width: 100%'>Delete</button>
            </div>
            <div class='well' style='cursor:pointer;' id='$note_id'>
            <div class='text'>$note</div>
            <div class='timetext'>$time</div>
            </div>
            </div>
            ";
        }
    }
    // Show notes or alert message
?>