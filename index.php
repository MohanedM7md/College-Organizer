<?php
    
   if (isset($_SESSION['user_id'])) {
    header("Location: Homepage.php");
    exit();
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CUFE Authentication</title>
        <link rel="stylesheet" href="css/style.css">
    
    </head>
    <body>
        <div class="wrapper">
            <header>
                <img src="images/CUFElogo.png" alt="CUFE Logo">
                <h1>College Organizer</h1>
            </header>

            <section id="main" class="auth-main">
                <h2>Welcome to CUFE</h2>
                <div class="auth-buttons">
                    <button id="login-btn">Login</button>
                    <button id="register-btn">Register</button>
                </div>

                <!-- Hidden Forms -->
                <div id="login-form" class="auth-form">
                    <h3>Login</h3>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="login">
                        <label for="login-id">ID:</label>
                        <input type="number" id="login-id" name="id" required>
                        <label for="login-password">Password:</label>
                        <input type="password" id="login-password" name="password" required>
                        <button type="submit">Submit</button>
                        <br>
                        <br>
                        <button type="button" id="close-login">Close</button>
                    </form>
                </div>

                <div id="register-form" class="auth-form">
                    <h3>Register</h3>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="register">

                        <label for="register-Fusername">User first name:</label>
                        <input type="text" id="register-Fusername" name="Fusername" required>
                        
                        <label for="register-Lusername">User last name:</label>
                        <input type="text" id="register-Lusername" name="Lusername" required>
                        
                        <label for="register-id">ID:</label>
                        <input type="number" id="register-id" name="id" required>

                        <label for="register-email">Email:</label>
                        <input type="email" id="register-email" name="email" required>

                        <label for="register-password">Password:</label>
                        <input type="password" id="register-password" name="password" required>

                        <label for="PhoneNo"><b>Phone number</b></label>
                        <input type="tel" placeholder="Phone number" name="PhoneNo" required>

                        <label for="Dep">Enter your departement</label>
                        <input list="departements" name="Dep" id="dep">
                        <datalist id="departements">
                            <option value="CCE">
                            <option value="SEE">
                            <option value="HEM">
                            <option value="EEE">
                            <option value="MPE">
                        </datalist>

                        <button type="submit" name="submit">Submit</button>
                        <br>
                        <br>
                        <button type="button" id="close-register">Close</button>
                    </form>
                    
                </div>
            </section>

            <footer>
                <p>&copy; 2020 CUFE Material Page | Designed by:  Mohaned</p>
            </footer>
        </div>
        <script src="auth.js"></script>
    </body>

</html>



<?php
     // Start session for both login and register
    include("MyDbConnection.php"); // Include database connection
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Determine the action type
        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            // Handle login
            $id = $_POST['id'];
            $password = $_POST['password'];

            // Validate login credentials
            $query = "SELECT ID, Fname, Lname, Email FROM stduser WHERE ID = '$id' AND Userpassword = '$password'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) === 1) {
                $user = mysqli_fetch_assoc($result);
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['user_name'] = $user['Fname'] . " " . $user['Lname'];
                $_SESSION['user_email'] = $user['Email'];

                // Redirect to homepage
                header("Location: Homepage.php");
                exit();
            } else {
                echo "Invalid login credentials.";
            }
        } elseif ($action === 'register') {
            // Handle registration
            $email = $_POST['email'];
            $Fname = $_POST['Fusername'];
            $ID = $_POST['id'];
            $Lname = $_POST['Lusername'];
            $password = $_POST['password'];
            $phone = $_POST['PhoneNo'];
            $dep = trim($_POST['Dep']);

            // Insert into database
            $sql = "INSERT INTO stduser (Email, Fname, ID, LName, Userpassword, Phone)
                    VALUES ('$email', '$Fname', '$ID', '$Lname', '$password', '$phone');";

            if (mysqli_query($conn, $sql)) {
                mysqli_query($conn, "INSERT INTO userdep (Dcode, UserID) VALUES ('$dep', '$ID')");

                $_SESSION['user_id'] = $ID;
                $_SESSION['user_name'] = $Fname . " " . $Lname;
                $_SESSION['user_email'] = $email;

                // Redirect to homepage
                header("Location: Homepage.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid action.";
        }
    } else {
        
                
    }

    // Close the database connection
    mysqli_close($conn);
?>

