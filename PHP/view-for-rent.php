    <!-- html header file -->
    <?php 
        include('./header.php');
        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['errors'][] = "Please login to access this content";
            header("Location: ./login.php");
            exit();
        }
        $acc_type = $_SESSION['type'] ?? null;
        $user = $_SESSION['user'];

    ?>
    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
    </head>
    <body>
        <?php include('./nav.php'); ?>
        <?php include_once('./notifications.php'); ?>

        <main class="container">
            <?php 
            
                try 
                {
                    // connection to the database 
                    require('config.php');

                    $sql = "SELECT * FROM vehicles WHERE username=:username";
                    // sql stmt 
                    if ($acc_type !== 'l') {
                        $sql = "SELECT * FROM vehicles";
                    }

                    // prepare the sql stmt 
                    $statement = $db->prepare($sql);

                    // bind the param 
                    if ($acc_type === 'l') {
                        $statement->bindParam(':username', $_SESSION['user']['username']);
                    }
                    // execute the statement 
                    $statement->execute(); 

                    // fetch all the reocrds 
                    $vehicles_records = $statement->fetchAll();

                    // display the details as a html table 
                    echo "<table class='table table-striped table-dark table-hover mt-3'>";
                    if ($acc_type === 'l') {
                        echo "<thead><td>Type</td><td>Make</td><td>Model</td><td>Year</td><td>Fuel Type</td><td>Price (Day)</td><td>Availablity</td>
                        <td>Edit</td><td style='color:red;'>Danger!</td></thead>";
                    }
                    else {
                        echo "<thead><td>Type</td><td>Make</td><td>Model</td><td>Year</td><td>Fuel Type</td><td>Price (Day)</td><td>Availablity</td></thead>";
                    }
                    echo "<tbody>";
                    foreach ($vehicles_records as $vehicles_record) 
                    {
                        echo "<tr><td>".$vehicles_record['type']."</td>
                        <td>".$vehicles_record['make']."</td>
                        <td>".$vehicles_record['model']."</td>
                        <td>".$vehicles_record['year_manufactured']."</td>
                        <td>".$vehicles_record['fuel_type']."</td>
                        <td>". number_format($vehicles_record['price'],2,'.',',') ."</td>
                        <td>".$vehicles_record['vehicle_status']."</td>";
                        if ($acc_type==='l') {
                            echo "<td><a href='editVehicles.php?id=".$vehicles_record['id']."' class='btn btn-primary btn-sm'>Edit</a></td>
                            <td><a href='delete_vehicle.php?id=".$vehicles_record['id']."' class='btn btn-sm btn-danger'>Delete</a></td>";
                        }
                        echo "<tr>";

                        $query = "SELECT * FROM vehicles WHERE id={$vehicles_record['id']}";
                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        $vehicles = $stmt->fetch(PDO::FETCH_ASSOC); 

                        $_SESSION['vehicle'] = $vehicles;

                        $stmt->closeCursor();
                        $statement->closeCursor();
                    } 
                    echo "</tbody></table>";

                    if ($acc_type === 'l') {
                        echo "<a href='./add_to_rent.php' class='btn btn-sm btn-primary'>Add Vehicles</a>";
                    }
                }
                catch (PDOException $e) 
                {
                    $error_message = $e->getMessage();
                    echo $error_message;
                    header('location: error.php');
                }

            ?>
        </main>
    </body>
</html>
