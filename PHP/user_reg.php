    
    <!-- ADD THE LOGIN FUNTIONALITY FOR PHASE 2 OF THE PROJECT -->

    <!-- html header file -->
    <?php 

        // starting the session 
        session_start();
        $form_values = $_SESSION['form_values'] ?? null;
        // clear the session var form values 
        unset($_SESSION['form_values']);


        // ob_start();
        include('./header.php'); 
    ?>




    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
    </head>
    <body>
            
        <!-- include the nav bar -->
        <?php 
            include_once('./nav.php'); 
            echo "<div>";
            // displays all errors as a notification
            include_once('./notifications.php');
            echo "</div>";
        ?>

        <main class="container">
            <form action="./data-process/reg_process.php" method="POST" class="my-3" novalidate>
            
                <div> 
                    <label class="form-label">Account Type</label>
                    <div>
                        <div class="form-check d-flex flex-row mx-2">
                            <label for="Rent" class="form-check-label">Rent Vehicles</label>
                            <input type="radio" name="type" id="type" class="form-check-input" value="r" required> 
                        </div>
                        <div class="form-check d-flex flex-row mx-2">
                            <label for="lessor" class="form-check-label">Put your car on Carex</label>
                            <input type="radio" name="type" id="type" class="form-check-input" value="l" required> 
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3 mb-3"> 
                    <div class="col"> 
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= $form_values['first_name'] ?? null ?>" required> 
                    </div>
                    <div class="col">
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= $form_values['last_name'] ?? null ?>" required> 
                    </div>
                </div>
                <div class="row mt-3 mb-3"> 
                    <div class="col">
                        <input type="number" name="age" id="age" class="form-control" placeholder="Age" value="<?= $form_values['age'] ?? null ?>" required> 
                    </div>
                    <div class="col">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?= $form_values['email'] ?? null ?>" required> 
                    </div>
                </div>
                
                
                <div class="row mt-3 mb-3" style="display: flex; align-items: center;">
                    <div class="col">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="<?= $form_values['phone'] ?? null ?>" required> 
                    </div>
                    <div class="col">
                        <label class="form-label">Gender</label>
                        <div class="col d-flex flex-row">
                            <div class="form-check d-flex flex-row mx-1">
                                <label for="Male" class="form-check-label">Male</label>
                                <input type="radio" class="form-check-input" name="gender" id="gender" value="M" required> 
                            </div>
                            <div class="form-check d-flex flex-row mx-2">
                                <label for="Male" class="form-check-label">Female</label>
                                <input type="radio" class="form-check-input" name="gender" id="gender" value="F" required>  
                            </div>
                            <div class="form-check d-flex flex-row mx-2">
                                <label for="Male" class="form-check-label">Other</label>
                                <input type="radio" class="form-check-input" name="gender" id="gender" value="O" required> 
                            </div>
                        </div>
                    </div>   
                </div>   
                    <!-- username and password  -->
                <div class="row mt-3 mb-3"> 
                    <div class="col"> 
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?= $form_values['username'] ?? null ?>" required> 
                    </div>
                    <div class="col"> 
                        <input type="text" name="confirm_username" id="confirm_username" class="form-control" placeholder="Confirm Username" required> 
                    </div>
                </div>

                <div class="row mt-3 mb-3"> 
                    <div class="col">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required> 
                    </div>
                    <div class="col">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required> 
                    </div>
                </div>

                <input type="submit" value="submit" class="btn btn-dark" name="submit" id="submit" required>
            </form>
            <!-- add the login in phase 2 -->
            <!-- <a href="./login_home.php">Already Have An Account</a> -->
            <a href="view-users.php" class="btn btn-dark my-3">View All Users</a>
            <a href="view-lessor.php" class="btn btn-dark my-3">View All lessors</a>

            <!-- recapcha field -->
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        </main>

        <?php  include_once('./google/config_reCaptcha.php'); ?> 
        <script src="https://www.google.com/recaptcha/api.js?render=<?= RECAPTCHASITEKEY ?>"></script>
        <script>
            grecaptcha.ready(() => {
                grecaptcha.execute("<?= RECAPTCHASITEKEY ?>", { action: "register" })
                .then(token => document.querySelector("#recaptchaResponse").value = token)
                .catch(error => console.error(error));  // set a field --> recaptchaResponse
            });
        </script>

        <?php 
            // get the account type 
            $_SESSION['user']['type'] = filter_input(INPUT_POST, 'type');
        ?>
    </body>
</html>