
<?php 
    ob_start();
    session_start();
    // google recaptcha 
    include_once('../google/config_reCaptcha.php');

     // error handler 
     function error_handler($errors) {

        if (count($errors) > 0) 
        {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_values'] = $_POST;
            
            header("Location: ../add_to_rent.php");
            exit;
        }
    }
    $errors = [];  // hold all the errors 

    // validating the recaptcha 
    if (!empty($_POST['recaptcha_response'])) {
        $secret_key = RECAPTCHASECRETKEY;
        $verify_recaptcha_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$_POST['recaptcha_response']}");
    
        // resposne data decoded 
        $response_data = json_decode($verify_recaptcha_response);

        if (!$response_data->success) {
            $errors[] = "Google reCaptcha dailed: ".($response_data->{'error-codes'})[0];
            error_handler($errors);
        }
    }


    /* Initialize Variables */
    $type = filter_input(INPUT_POST, 'type');
    $make   = filter_input(INPUT_POST, 'make');
    $model = filter_input(INPUT_POST, 'model');
    $year = filter_input(INPUT_POST, 'year');
    $fuel_type = filter_input(INPUT_POST, 'fuel_type');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $vehicle_status = true;
    $username = filter_input(INPUT_POST, 'username');


    $required_fields = [
        'type',
        'make',
        'model',
        'year',
        'fuel_type', 
        'price'
    ];

   // cheking wheather all required fields are filled 
    foreach ($required_fields as $required_field) 
    {
        if (empty($$required_field)) 
        {
            $readable = str_replace("_" , " ", $required_field);
            $errors[] = "{$readable} cannot be blank";
        }
        else 
        {
            $$required_field = filter_var($$required_field, FILTER_SANITIZE_STRING);
        }
    }


    // validation of email 
    if ($price === false) 
    {
        $errors[] = "Amount Entered is not valid!";
    }
    error_handler($errors);


    if (sizeof($errors) === 0) 
    {
        try 
        {
            // connect to the db 
            require('../config.php');

            // sql stmt to add records 
            $sql = "INSERT INTO `vehicles` (username,type, make, model, year_manufactured, fuel_type, price,vehicle_status)
                        VALUES (:username,:type, :make, :model, :year_manufactured, :fuel_type, :price, :vehicle_status);"; 
            // prepare the sql stmt 
            $statement = $db->prepare($sql);
            
            $statement->bindParam(':username',$username); 
            
            // bind the parameters 
            $statement->bindParam(':type',$typ); 
            $statement->bindParam(':make',$make); 
            $statement->bindParam(':model',$model); 
            $statement->bindParam(':year_manufactured',$year); 
            $statement->bindParam(':fuel_type',$fuel_type); 
            $statement->bindParam(':price',$price); 
            $statement->bindParam(':vehicle_status',$vehicle_status); 

            // execute the prepared sql stmt 
            $statement->execute();
            $statement->closeCursor();

            $_SESSION['successes'][] = "You have successfully registered your vehicle with Carex";

            // after adding navigate to the view rent page 
            header('location: ../view-for-rent.php');
        } 
        catch (PDOException $e) 
        {
            $errors[] = $e->getMessage();
        }
    }
    ob_flush();
?>