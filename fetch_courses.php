<?php
header('Content-Type: application/json');
include("MyDbConnection.php");

if (isset($_GET['dcode'])) {
    $dcode = mysqli_real_escape_string($conn, $_GET['dcode']);

    // Fetch courses for the selected department
    $coursesQuery = mysqli_query($conn, "SELECT CourseCode FROM depcourse WHERE Dcode = '$dcode'");
    $courses = [];

    while ($row = mysqli_fetch_assoc($coursesQuery)) {
        $courses[] = $row;
    }

    if (!empty($courses)) {
        echo json_encode(['success' => true, 'courses' => $courses]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

mysqli_close($conn);
?>
