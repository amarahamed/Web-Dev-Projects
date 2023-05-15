

<?php 

    ob_start();

    try 
    {
        $id = filter_input(INPUT_GET, 'user_id');
        // connect to db 
        require('config.php');
        // sql to delete record 
        $sql = "DELETE FROM renter WHERE id=:lessor_id;";
        // prepare he sql 
        $statement = $db->prepare($sql); 

        // bind param 
        $statement->bindParam(':lessor_id', $id);
        // execute stmt 
        $statement->execute();
        // close connection to db 
        $statement->closeCursor();

        header('location: view-lessor.php');
    }
    catch (PDOException $e) 
    {
        header('location: error.php');
    }

    ob_flush();

?>