
<?php  
    // if session is not started start the session 
    if (session_status() === PHP_SESSION_NONE) 
    {
        session_start();  
    }
    // getting all the error messages from the session 
    $errors = $_SESSION['errors'] ?? null; 
    // getting all the successes messages from the session 
    $successes = $_SESSION['successes'] ?? null;

    // unsetting the session errors and successes 
    unset($_SESSION['errors']);
    unset($_SESSION['successes']);
    
    foreach (['danger' => $errors, 'success' => $successes] as $alert => $messages) 
    {
        _message($messages, $alert);
    }
    
    function _message($messages, $alert)  
    {   // checking if there is a message 
        if ($messages && count($messages) > 0) 
        {
            echo "<div class='alert alert-{$alert}'>";
            foreach ($messages as $message) 
            {
                echo "{$message}<br>";
            }
            echo "</div>";
        }
    }
?>