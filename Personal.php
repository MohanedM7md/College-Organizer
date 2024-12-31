<?php
session_start();
include("MyDbConnection.php");

$query = NULL;
$message = ""; // Initialize message variable

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["email"])) {
    $newEmail = $_POST['email'];
    $newPhone = $_POST['telephone'];

    // Update query
    $query = "UPDATE stduser SET Email = '$newEmail', Phone = '$newPhone' WHERE ID = $user_id";
    if (mysqli_query($conn, $query)) {
        $message = "Your information has been updated successfully!";
    } else {
        $message = "Error updating information: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personal Information</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            position: relative; /* Allows positioning of child elements like the close button */
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        .form-container label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 0.5rem;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 1rem;
            color: green;
        }

        .error {
            text-align: center;
            margin-top: 1rem;
            color: red;
        }

        /* Styles for the close button (X) */
        .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #555;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <!-- Close button -->
        <a href="Homepage.php" class="close-btn" title="Go to Homepage">&times;</a>

        <h2>Edit Personal Information</h2>
        <form method="POST" action="Personal.php">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter New Email" required>

            <label for="telephone">Telephone:</label>
            <input type="tel" name="telephone" id="telephone" placeholder="Enter new Phone Number" required>

            <button type="submit">Save Changes</button>
        </form>

        <!-- Display message -->
        <?php if (!empty($message)): ?>
            <div class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
