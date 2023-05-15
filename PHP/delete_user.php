
<?php 
    ob_start();

    $id = filter_input(INPUT_GET, 'user_id');

    try 
    {
        // connect to db 
        require('config.php');
        // sql stmt to delete record 
        $sql = "DELETE FROM rentee WHERE id=:user_id";
        // prepare the sql stmt 
        $statement = $db->prepare($sql);
        // bind the prarameter 
        $statement->bindParam(':user_id', $id);
        // execute 
        $statement->execute();
        // close connection 
        $statement->closeCursor();
        // navigate the user to the view 
        header('location: view-users.php');
    }
    catch(PDOException $e) 
    {
        header('location: error.php');
    }

    ob_flush();
?>