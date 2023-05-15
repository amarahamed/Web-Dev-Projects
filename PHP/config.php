
<?php 
    // connecting to the database 
    try 
    {
        $dsn ='mysql:host=172.31.22.43;dbname=Amar200442824';
        $server_username = 'Amar200442824';
        $server_password = 'KLlMZtZVEw';
        
        // for my localhost
        // $dsn = 'mysql:host=localhost;dbname=car_rental;';
        // $server_username = 'root';
        // $server_password = 'opensqlserverforme1160';
        $db = new PDO($dsn, $server_username, $server_password);
        // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) 
    {
        var_dump($e->getMessage());
    }
?>

