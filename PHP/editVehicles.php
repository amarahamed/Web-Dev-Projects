<?php 
        ob_start();
        // html header file
        include('./header.php'); 

        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['errors'][] = "Please login to access this page";
            header("Location: ./login.php");
            exit();
        }
        // gets the id from the URL 
        $id = filter_input(INPUT_GET, 'id');
        // 
        $id_changed = false;

        if ($id === null) 
        {
            $id_changed = true;
        }
        
        if ($id_changed === false) {
            $_SESSION['id'] = $id;
        }

        $vehicle = $_SESSION['vehicle'];

        $form_values = $_SESSION['form_values'] ?? $vehicle;
        unset($_SESSION['form_values']);
    ?>


    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
    </head>

    <body>
        <!-- include the nav bar -->
        <?php 
            include('./nav.php'); 
            include_once('notifications.php');
        ?> 
        
        <main class="container">
         <form action="./data-process/updateVehicles.php" method="POST" class="my-3">
                <?php
                    echo "<input type='hidden' name='id' id='id' value='{$_SESSION['id']}'>";
                ?>
                <div class="my-3"> 
                    <label>Vehicle Type</label>
                    <div class="d-flex flex-row my-1">
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Sedan</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-sedan" <?php echo ($vehicle['type']=='car-sedan')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Coupe</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-coupe" <?php echo ($vehicle['type']=='car-coupe')?'checked':'' ?> required>
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Hatchback</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="car-hatchback" <?php echo ($vehicle['type']=='car-hatchback')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">SUV</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="suv" <?php echo ($vehicle['type']=='suv')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Truck</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="truck" <?php echo ($vehicle['type']=='truck')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Van</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="van" <?php echo ($vehicle['type']=='van')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Wagon</label>
                            <input type="radio" name="type" class="form-check-input" id="type" value="wagon" <?php echo ($vehicle['type']=='wagon')?'checked':'' ?> required> 
                        </div>
                    </div>  <!-- end of the radio button section  -->
                </div>
                <div class="row my-3">
                    <div class="col">
                        <input type="text" name="make" id="make" class="form-control"  placeholder="Make" value="<?= $form_values['make'] ?>" required> 
                    </div>
                    <div class="col"> 
                        <input type="text" name="model" id="model" class="form-control" placeholder="Model" value="<?= $form_values['model'] ?>" required> 
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Year (Select year & any month)</label>
                        <input type="month" name="year" id="year" class="form-control" value="<?= $form_values['year_manufactured']."-01"?>" required>
                    </div>
                    <div class="col">
                        <label>Price (For a day)</label>
                        <input type="text" name="price" id="price" placeholder="0.00" class="form-control" value="<?= number_format($form_values['price'],2) ?? null ?>" required> 
                    </div> 
                </div>
                <div class="my-3">
                    <label>Fuel Type</label>
                    <div class="d-flex flex-row mx-2">
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Gas</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fueltype" value="gas" <?php echo ($vehicle['fuel_type']=='gas')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Diesel</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fueltype" value="diesel" <?php echo ($vehicle['fuel_type']=='diesel')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Electric</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fueltype" value="electric" <?php echo ($vehicle['fuel_type']=='electric')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Hybrid</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fueltype" value="hybrid" <?php echo ($vehicle['fuel_type']=='hybrid')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>PHEV</label>
                            <input type="radio" name="fuel_type" class="form-check-input" id="fueltype" value="PHEV" <?php echo ($vehicle['fuel_type']=='PHEV')?'checked':'' ?> required> 
                        </div>
                    </div>
                </div>

                <div class="my-3">
                    <label>Vehicle Availablity</label>
                    <div class="d-flex flex-row mx-2">
                        <div class="col d-flex flex-row">
                            <label class="form-check-label">Available</label>
                            <input type="radio" name="vehicle_status" class="form-check-input" id="vehicle_status" value="1" <?php echo ($vehicle['vehicle_status']=='1')?'checked':'' ?> required> 
                        </div>
                        <div class="col d-flex flex-row">
                            <label>Not Available</label>
                            <input type="radio" name="vehicle_status" class="form-check-input" id="vehicle_status" value="0" <?php echo ($vehicle['vehicle_status']=='0')?'checked':'' ?> required> 
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