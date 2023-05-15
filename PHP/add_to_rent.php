    <?php 
        ob_start();
        // html header file
        include('./header.php'); 

        session_start();
        if (!isset($_SESSION['user'])) {
            // $_SESSION['errors'][] = "Please login";
            header("Location: ./login.php");
            exit();
        }
        $user = $_SESSION['user'];
        $username = $user['username'];

        
        $form_values = $_SESSION['form_values'] ?? null;
        
        // clear the session var form values 
        unset($_SESSION['form_values']);

        
        ob_flush();
    ?>


    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
    </head>

    <body>
        <!-- include the nav bar -->
        <?php 
            include('./nav.php'); 
            include_once('./notifications.php');
        ?> 

        
        <main class="container">
         <form action="./data-process/reg_vehicle.php" method="POST" class="my-3" novalidate>
                <?php  
                    echo "<input type='hidden' name='username' id='username' value='$username'>";
                ?>
                <div class="my-3"> 
                    <label>Vehicle Type</label>
                    <div class="d-flex flex-row my-1">
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Sedan</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-sedan"  required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Coupe</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-coupe"  required>
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Hatchback</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-hatchback"  required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">SUV</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="suv" equired> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Truck</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="truck"  required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Van</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="van" equired> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Wagon</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="wagon"  required> 
                        </div>
                    </div>  <!-- end of the radio button section  -->
                </div>
                <div class="row my-3">
                    <div class="col">
                        <input type="text" name="make" id="make" class="form-control"  placeholder="Make" value="<?= $form_values['make'] ?? null ?>" required> 
                    </div>
                    <div class="col"> 
                        <input type="text" name="model" id="model" class="form-control" placeholder="Model" value="<?= $form_values['model'] ?? null ?>" required> 
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Year (Select year & any month)</label>
                        <input type="month" name="year" id="year" class="form-control" value="<?= $form_values['year_manufactured']."-01" ?? null ?>" required>
                    </div>
                    <div class="col">
                        <label>Price (For a day)</label>
                        <input type="text" name="price" id="price" placeholder="0.00" class="form-control" value="<?= $form_values['price'] ?? null ?>" required> 
                    </div> 
                </div>
                <div class="my-3">
                    <label>Fuel Type</label>
                    <div class="d-flex flex-row mx-2">
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Gas</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fuel_type" value="gas" required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Diesel</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fuel_type" value="diesel"  required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Electric</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fuel_type" value="electric"  required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Hybrid</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fuel_type" value="hybrid" required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>PHEV</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fuel_type" value="PHEV"  required> 
                        </div>
                    </div>
                </div>


                <!-- recapcha field -->
                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

                <input type="submit" value="submit" name="submit" id="submit" class="btn btn-dark" required>
            </form>
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

    </body>
</html>