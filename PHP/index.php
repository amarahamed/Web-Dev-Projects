    <!-- html header file -->
    <?php include('./header.php'); ?>
    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
        <style>
            main > div {
                height: 400px;
            }
        </style>
    </head>
    <body>
        <!-- include the nav bar -->
        <?php include('./nav.php'); ?>
        
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">looking for rent?</a>

                <form class="d-flex" method="GET" action="./data-process/search_vehicles.php">
                    <input class="form-control me-2" type="text" name="seached_vehicle" id="seached_vehicle" placeholder="Search a vehicle to rent (Seach by make,model,type)" aria-label="Search">
                    <button class="btn btn-primary mx-2" type="submit" name="submit"><i class="fas fa-search"></i></button>
                </form>

            </div>
        </nav>
        <?php include_once('./notifications.php'); ?>
        <main class="container">
            <div class="container-sm d-flex justify-content-center align-items-center flex-column">
                <img src="./img/showcase.png" alt="Showcase" class="img-fluid">
                <h1 class="display-3">Rent a car with us</h1>
                <p class="lead">Always the ride you want request a ride, hop in, and go.</p>
            </div>
        </main>

    </body>
</html>