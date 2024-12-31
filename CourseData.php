<?php
include("MyDbConnection.php");

if (isset($_GET['courseCode'])) {
    $courseCode = $_GET['courseCode'];

    // Fetch course details from the database
    $query = mysqli_query($conn, "SELECT * FROM courses WHERE CourseCode = '$courseCode'");
    $courseDetails = mysqli_fetch_assoc($query);

    if ($courseDetails) {
        echo json_encode($courseDetails); // Return the course details as JSON
    } else {
        echo json_encode(['error' => 'Course not found']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['error' => 'No course code provided']);
}
?>
