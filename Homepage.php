<?php
    include("MyDbConnection.php"); // Include database connection
    session_start();
    if (isset($_SESSION['user_id'])) {
        // Access user data
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $user_email = $_SESSION['user_email'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUFE Material Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <img src="images/CUFElogo.png" alt="CUFE Logo">
            <h1>College Organizer</h1>
        </header>

        <nav>
            <ul>
                <li><a href="Homepage.php">Home</a></li>
                <li><a href="Departments.php">Departments</a></li>
                <li><a href="courses.php">My courses</a></li>
                <li ><a href="Personal.php">Edit my profile</a></li>
                <li style="margin-left:auto;">
                    <form action="signout.php" method="post" style="display:inline;">
                        <button type="submit" name="submit" style="
                            background: none;
                            border: none;
                            color: white;
                            font-size: 1rem;
                            cursor: pointer;
                            text-decoration: underline;
                        ">Sign Out</button>
                    </form>
                </li>
            </ul>
        </nav>

        <section id="main">
            <div class="container">
                <!-- Main Content -->
                <article>
                    <h1>Welcome <p style="display: inline; color:red"><?=$user_name?> </P>to CUFE Material Page</h1>
                    <marquee>Stay Home, Stay Safe...</marquee>
                    <p>The CUFE page provides resources and updates for all departments...</p>
                    <p> You are enrolled in Courses </p>
                </article>

                <!-- Sidebar -->
                <aside>
                    <h2>Quick Links</h2>
                    <ul>
                        <li><a href="#">Graduates</a></li>
                        <li><a href="#">More about us</a></li>
                        <!-- <li><a href="#">IDK</a></li> -->
                    </ul>
                    <h2>Contact Us</h2>
                    <!-- <img src="images/address.png" alt="Address" style="width: 100%; border-radius: 8px;"> -->
                </aside>
            </div>
        </section>

        <footer>
            <p>&copy; 2020 CUFE Material Page | Designed by: Mohaned</p>
            <a href="#"><img src="images/icons8-google-48.png" alt="Google"></a>
            <a href="#"><img src="images/icons8-facebook-48.png" alt="Facebook"></a>
            <a href="#"><img src="images/icons8-play-button-48.png" alt="YouTube"></a>
        </footer>
    </div>
</body>

</html>
