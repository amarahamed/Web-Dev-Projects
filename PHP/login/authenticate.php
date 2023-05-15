
<?php 
    ob_start();
    require('../config.php');
    
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    
    $acc = filter_input(INPUT_POST, 'acc_type');

    $sql = null;
    
    if ($acc === 'r') {
        $sql = "SELECT * FROM rentee WHERE username=:username";
    }
    if ($acc === 'l') {
        $sql = "SELECT * FROM renter WHERE username=:username";
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    $stmt->execute();

    $user = $stmt->fetch(pdo::FETCH_ASSOC);
    $user_authorized = false;

    if ($user) {
        // @return - true/false  
        $user_authorized = password_verify($password, $user['password']);  // verifying passowrd 
    }
    session_start(); 

    if (!$user_authorized) {
        // $_SESSION["errors"][] = "Your username and password couldn't be verified";
        $_SESSION["form_values"] = $_POST;

        header("Location: ../login.php");
        exit();
    }   

    $_SESSION["user"] = $user;
    $_SESSION['type'] = $acc ?? null;

    // $_SESSION["successes"][] = "You have logged in successfully";
    header("Location: ../view-for-rent.php");
    ob_flush();
    exit();
?>