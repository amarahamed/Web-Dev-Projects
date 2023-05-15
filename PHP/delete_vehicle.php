<?php 

    ob_start();

    try 
    {
        // delete using the user id passed when the delete btn is clicked 
        $vehicle_id = filter_input(INPUT_GET, 'id');

        // connect database 
        require('config.php');

        // sql stmt
        $sql = "DELETE FROM vehicles WHERE id=:vehicle_id;";
        
        // prepare stmt 
        $statement = $db->prepare($sql);

        // bind the param 
        $statement->bindParam(':vehicle_id', $vehicle_id);

        // execute stmt 
        $statement->execute();

        // close connection 
        $statement->closeCursor();

        // nav baack to view 
        header('location: view-for-rent.php');

    }
    catch (PDOException $e) 
    {
        header('location: error.php');
    }

    ob_flush();
?>