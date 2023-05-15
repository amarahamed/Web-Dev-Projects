<!-- add header -->
<?php require('header.php'); ?> 
<head>
    <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
</head>
<body>
    <!-- include the nav bar -->
    <?php include('./nav.php'); ?>

    <main class="container">
        <?php 
            // acctount type 
            $type = 'l';
            try 
            {
                // connect to the db 
                require('config.php');
                // sql stmt to select everthing from customers table 
                $sql = "SELECT * FROM renter";
                // prepare sql 
                $statement =  $db->prepare($sql);
                // execute the stmt 
                $statement->execute();

                $records = $statement->fetchAll();
                
                echo "<table class='table table-dark table-hover my-3'><thead><td>First Name</td><td>Last Name</td><td>Age</td><td>Gender</td><td>Email</td><td>Phone</td><td>Edit</td><td style='color:red;'>Danger!</td></thead>
                <tbody>";
                
                foreach ($records as $record) 
                {
                    echo "<tr>
                    <td>".$record['first_name']."</td>
                    <td>".$record['last_name']."</td>
                    <td>".$record['age']."</td>
                    <td>".$record['gender']."</td>
                    <td>".$record['email']."</td>
                    <td>".$record['phone']."</td>
                    <td><a href='user_reg.php?user_id=".$record['id']."&type=".$type."' class='btn btn-primary btn-sm'>Edit</a></td>
                    <td><a href='delete_lessor.php?user_id=".$record['id']."' class='btn btn-danger btn-sm'>Delete</a></td>
                    </tr>";
                }                
                echo "</tbody></table>";
                // close db connections 
                $statement->closeCursor();
                echo "<a href='user_reg.php' class='btn btn-dark'>Add Users</a>";

            }
            catch (PDOException $e) 
            {
                header('location: error.php');
            }   
        ?>
    </main>


