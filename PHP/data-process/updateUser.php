

<?php 
    // google recaptcha 
    include_once('../google/config_reCaptcha.php');

    session_start();  // starting the session
    $acc_type = $_SESSION['type'] ?? null;

    // error handler 
    function error_handler($errors) 
    {

        if (count($errors) > 0) 
        {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_values'] = $_POST;
            
            header("Location: ../editUser.php");
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

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $gender = filter_input(INPUT_POST, 'gender');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');

    $username = filter_input(INPUT_POST, 'username');
    $confirm_username = filter_input(INPUT_POST, 'confirm_username');

    $required_fields = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'email', 
        'phone',
        'username',
        'confirm_username'
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
    if ($email === false) 
    {
        $errors[] = "Email entered is not valid";
    }
    // validation of Age  
    if ($age === false) 
    {
        $errors[] = "Age entered is not valid";
    }
    // convert email to all lowercase 
    $email = strtolower($email);

    if($username !== $confirm_username) {
        $errors[] = "Username and Username confirmation doesn't match";
    }

    /// clear the username confirmation 
    unset($confirm_username);

    error_handler($errors);


     // only continues if there is no errors 
     if (sizeof($errors) === 0) 
     {
         try 
         {
             // connecting to th data base 
             require('../config.php');
 
             if ($acc_type == 'r')
             {
                 
                $sql = "UPDATE rentee 
                SET first_name=:first_name, last_name=:last_name, age=:age, gender=:gender,email=:email, phone=:phone,username=:username
                WHERE id=:user_id;";
                
                // preparing the sql stmt 
                $statement = $db->prepare($sql);
     
                // bind the parameters
                $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                $statement->bindParam(':last_name',$last_name, PDO::PARAM_STR);
                $statement->bindParam(':age',$age, PDO::PARAM_INT);
                $statement->bindParam(':gender',$gender);
                $statement->bindParam(':email',$email, PDO::PARAM_STR);
                $statement->bindParam(':phone',$phone, PDO::PARAM_STR); 
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
                
 
                // execute the sql stmt 
                $statement->execute();
 
                $_SESSION['successes'][] = "You have successfully updated your account with Carex";
                
                # update the session user with the updated details 
                $user = $db->query("SELECT * FROM rentee WHERE id={$_SESSION['user']['id']}");

                $_SESSION['user'] = $user;

                 // close the db connection 
                 $statement->closeCursor();
                 header('location: ../profile.php');
             }
             if ($acc_type == 'l')
             {
                //sql stmt to update the data 
                $sql = "UPDATE renter 
                        SET first_name=:first_name, last_name=:last_name, age=:age,gender=:gender, email=:email, phone=:phone, username=:username 
                        WHERE id=:user_id";
                // preparing the sql stmt 
                $statement = $db->prepare($sql);
                 
                // bind the parameters
                $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                $statement->bindParam(':last_name',$last_name, PDO::PARAM_STR);
                $statement->bindParam(':age',$age, PDO::PARAM_INT);
                $statement->bindParam(':gender',$gender);
                $statement->bindParam(':email',$email, PDO::PARAM_STR);
                $statement->bindParam(':phone',$phone, PDO::PARAM_STR);
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);

                // execute the sql stmt 
                $statement->execute();

                $_SESSION['successes'][] = "You have successfully updated your account with Carex";

                # update the session user with the updated details 
                $user = $db->query("SELECT * FROM renter WHERE id={$_SESSION['user']['id']}");
                
                $_SESSION['user'] = $user;
                
                // close the db connection 
                $statement->closeCursor();
                header('location: ../profile.php');
             }
         } catch (PDOException $e) {
             $errors[] = $e->getMessage(); 
            }
            error_handler($errors);
        }




    


?>