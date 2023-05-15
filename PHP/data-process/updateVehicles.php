

<?php 
    // google recaptcha 
    include_once('../google/config_reCaptcha.php');

    session_start();  // starting the session

    // error handler 
    function error_handler($errors) 
    {

        if (count($errors) > 0) 
        {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_values'] = $_POST;
            
            header("Location: ../editVehicles.php");
            exit;
        }
    }
    $errors = [];

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

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); 

    $type = filter_input(INPUT_POST, 'type');
    $make   = filter_input(INPUT_POST, 'make');
    $model = filter_input(INPUT_POST, 'model');
    $year = filter_input(INPUT_POST, 'year');
    $fuel_type = filter_input(INPUT_POST, 'fuel_type');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $vehicle_status  = filter_input(INPUT_POST,'vehicle_status');
    

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
    // if id Couldnt be caught 
    if (empty($id)) 
    {
        $errors[] = "Oops something went wrong";
    }
    error_handler($errors);


    // only continues if there is no errors 
    if (sizeof($errors) === 0) 
    {
        try 
        {
            require_once('../config.php');
            
            $sql = "UPDATE vehicles 
            SET type=:v_type, make=:make, model=:model, year_manufactured=:year_manufactured,fuel_type=:fuel_type, price=:price,vehicle_status=:vehicle_status
            WHERE id=:id;";
            
            // preparing the sql stmt 
            $statement = $db->prepare($sql);
    
            // bind the parameters
            $statement->bindParam(':v_type', $type, PDO::PARAM_STR);
            $statement->bindParam(':make',$make, PDO::PARAM_STR);
            $statement->bindParam(':model',$model, PDO::PARAM_STR);
            $statement->bindParam(':year_manufactured',$year, PDO::PARAM_INT);
            $statement->bindParam(':fuel_type',$fuel_type, PDO::PARAM_STR);
            $statement->bindParam(':price',$price); 
            $statement->bindParam(':vehicle_status',$vehicle_status); 
            

            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            

            // execute the sql stmt 
            $statement->execute();

            $_SESSION['successes'][] = "You have successfully updated your vehicle with Carex";

            $vehicle = $db->query("SELECT * FROM vehicles WHERE id=$id");

            $_SESSION['vehicle'] = $vehicle;


            // close the db connection 
            $statement->closeCursor();
            header('location: ../view-for-rent.php');
            // connecting to th data base 
            require('../config.php');
        } 
        catch (PDOException $e) 
        {
            $errors[] = $e->getMessage(); 
            error_handler($errors);
        }
    }
?>