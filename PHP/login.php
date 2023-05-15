

<?php 
    ob_start();
    session_start();  // start the session 

    if (isset($_SESSION['username'])) {
        header("Location: ./view-for-rent.php");
        exit();
    }

    $form_values = $_SESSION['form_values'] ?? null; 
    unset($_SESSION['form_values']);

    include('./header.php'); 
    ob_flush();
?>

    <!-- html header file -->
    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
    </head>
    <body>
        <!-- include the nav bar -->
        <?php include('./nav.php'); ?>
        <?php include_once('./notifications.php'); ?>
        
        <main class="container d-flex">
        <div class="container d-flex align-items-center justify-content-center my-3 login-container">

                <form action="login/authenticate.php" method="POST">
                    <h2 class="mx-3">Welcome to Carex</h2>
                    <p class="lead mx-3">Sign in with your credentials</p>
                    <div class="mx-3">  
                        <label class='form-label'>Account Type</label>
                        <div>
                            <div class='form-check d-flex flex-row mx-2'>
                                <label for='Rent' class='form-check-label'>Renter - Put your car on Carex</label>
                                <input type='radio' name='acc_type' id='acc_type' class='form-check-input' value='l'  required> 
                            </div>
                            <div class='form-check d-flex flex-row mx-2'>
                                <label for='lessor' class='form-check-label'>Rentee - Rent vehicles</label>
                                <input type='radio' name='acc_type' id='acc_type' class='form-check-input' value='r' required> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="m-3">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Type your username" value="<?= $form_values['username'] ?? null ?>" required>
                    </div>
                    <div class="m-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Type your password" required>
                    </div>
                    <button class="btn btn-primary btn-sm mx-3 my-1" type="submit" value="submit">SUBMIT</button>
                    <a class="btn btn-secondary btn-sm my-1" href="./user_reg.php">Sign Up</a> 
                </form>

            </div>  
        </main>
    </body>
</html>



