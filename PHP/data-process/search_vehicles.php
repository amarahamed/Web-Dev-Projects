
<?php 
    require('./header_dataprocess.php');
    require('./nav_dataprocess.php');
    
    echo "<div class='container'>";
    $submit = filter_input(INPUT_GET, 'submit');
    $seached_vehicle = filter_input(INPUT_GET, 'seached_vehicle');
    
    // conect to the db
    require('../config.php');

    $sql = "SELECT type, make, model, year_manufactured, fuel_type, price, vehicle_status  FROM vehicles WHERE make LIKE :seached_vehicle OR
     model LIKE :seached_vehicle OR type LIKE :seached_vehicle;";
    // prepare sql stmt 
    $stmt = $db->prepare($sql);

    // bind value 
    $stmt->bindValue(':seached_vehicle', '%'.$seached_vehicle.'%');
    // execute the stmt 
    $stmt->execute();
    // at least 1 row should be fetched from the sql query to get results 
    if ($stmt->rowCount() >= 1)
    {
        echo "<table class='table table-striped table-dark table-hover mt-3'>";
        echo "<thead><td>Type</td><td>Make</td><td>Model</td><td>Year</td><td>Fuel Type</td><td>Price (Day)</td><td>Availablity</td></thead>";
        echo "<tbody>";
        // while all records are fetched 
        while ($results = $stmt->fetch())
        {
            // only the available cars will be displayed 
            if ($results['vehicle_status'] == 1)
            {
                echo "<tr><td>".$results['type']."</td>
                <td>".$results['make']."</td>
                <td>".$results['model']."</td>
                <td>".$results['year_manufactured']."</td>
                <td>".$results['fuel_type']."</td>
                <td>". number_format($results['price'],2,'.',',') ."</td>
                <td>".$results['vehicle_status']."</td>
                <tr>";
            }
        }
        echo "</tbody></table>";
    }
    else 
    {
        echo "<div class='my-3'>";
            echo "<p>It looks like there aren't any matches for your search</p>";
            echo "<p><strong>Suggestions: </strong><p>";
            echo "<ul>";
            echo "<li>Make sure that all words are spelled correctly.</li>";
            echo "<li>Try different keywords.</li>";
            echo "<li>Check the typed make/model/type is valid</li>";
            echo "</ul>";
        echo "</div>";
    }
    echo "</div>";
    // closeing the connection to the db 
    $stmt->closeCursor();

?>