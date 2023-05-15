


<?php 

    if (session_status() == PHP_SESSION_NONE)  {
        session_start();
    }
    $user = $_SESSION["user"]['username'] ?? "Profile";

    if (!isset($_SESSION['user'])) 
    {
        echo "<header>
            <nav>
                <div>
                    <img src='./img/logo.png' alt='Rent A Car'>
                    <p class='logo'>Carex</p>
                </div>
                <ul>
                    <li><a href='./index.php'>Home</a></li>
                    <li><a href='./about.php'>About</a></li>
                    <li><a href='./contact.php'>Contact</a></li>
                    <li><a href='./view-for-rent.php'>Rent</a></li>
                    <li><a href='./login_home.php'>Login</a></li>
                </ul>
            </nav>
        </header>";
    }
    else 
    {
        echo "
            <header>
            <nav>
                <div>
                    <img src='./img/logo.png' alt='Rent A Car'>
                    <p class='logo'>Carex</p>
                </div>
                <ul>
                    <li><a href='./index.php'>Home</a></li>
                    <li><a href='./about.php'>About</a></li>
                    <li><a href='./contact.php'>Contact</a></li>
                    <li><a href='./view-for-rent.php'>Rent</a></li>
                    <li><a href='./profile.php'>".$user."</a></li>
                    <li><a href='./login/logout.php' class='btn btn-danger btn-sm'>Sign out</a></li>
                </ul>
            </nav>
        </header>
        ";
    }


    
?>