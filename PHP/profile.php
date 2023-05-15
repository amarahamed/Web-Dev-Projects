    <!-- html header file -->
    <?php 
        include('./header.php'); 

        session_start();
        // allows only if the user is logged in 
        if (!isset($_SESSION["user"])) {

            // $_SESSION['errors'][] = "Please login to access this content";
            header("Location: ./login.php");
            exit();
        }
        $user = $_SESSION['user'];
    ?>

    <head>
        <title>Rent a Car at Carex| Different types of vehicles available for rent</title>
        <!--    Link to font awesome      -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    </head>
    <body>
        <!-- include the nav bar -->
        <?php include('./nav.php'); ?>
        <?php include_once('./notifications.php'); ?>
      
        <main class="container">

        <div class="row my-3">
          <div class="col-3">
            <i class="fas fa-user fa-10x"></i>
          </div>
          <div class="col-7">
            <h1 class="text-capitalize">Welcome <?= $_SESSION['user']['username'] ?? null ?></h1>
            <p class="lead">Thank you for choosing Carex</p>
            <hr class="my-4">
            <p class="lead">Always the ride you want, request a ride, hop in, and go.</p>
            <a href="./editUser.php" class="btn btn-primary">Edit Profile</a>
          </div>
        </div>
           
        </main>

    </body>
</html>