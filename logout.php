<?php
    //Starts the existing session so PHP can access it.
    session_start();
    //Removes the session variables: eg:$_SESSION['user_id']
    session_unset();
    //Destroys the session itself.
    session_destroy();
    
    header("Location: index.php");
    exit();
?>


