<?php
include("MyDbConnection.php"); // Include database connection
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
}

// Fetch available courses
$query2 = mysqli_query($conn, "SELECT CourseCode FROM depCourse 
    WHERE Dcode = (SELECT Dcode FROM userdep WHERE UserID = $user_id) 
    AND CourseCode NOT IN (SELECT CourseCode FROM usercourse WHERE UserID = $user_id)");
$courseCodes = [];

while ($row = mysqli_fetch_assoc($query2)) {
    $courseCodes[] = $row['CourseCode'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' && isset($_POST['courses'])) {
        $courses = explode(",", $_POST['courses'][0] ?? '');
        foreach ($courses as $course) {
            $course = mysqli_real_escape_string($conn, $course);
            mysqli_query($conn, "INSERT INTO usercourse (CourseCode, UserID) VALUES ('$course', $user_id)");
        }
    } elseif ($action === 'delete' && isset($_POST['delete_courses'])) {
        $delete_courses = explode(",", $_POST['delete_courses'][0] ?? '');
        foreach ($delete_courses as $course) {
            $course = mysqli_real_escape_string($conn, $course);
            mysqli_query($conn, "DELETE FROM usercourse WHERE CourseCode = '$course' AND UserID = $user_id");
        }
    }

    mysqli_close($conn);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUFE Materials</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #course-details-container {
    display: none;
    padding: 20px;
    background-color: #f4f4f4;
}

#course-details {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#close-course-details-btn {
    background-color: red;
    color: white;
    font-size: 20px;
    border: none;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 50%;
}

    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            <img src="images/CUFElogo.png" alt="CUFE Logo">
            <h1>CUFE Material Cards</h1>
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

        <main>

            <div class = "Addcourses">
                <button id="Edit-btn">Edit Courses</button>
                <div id="Courses-form" class="auth-form">
                    <h3>Edit Courses</h3>
                    <form action="Courses.php" method="post">
                        <h3>Edit Courses</h3>

                        <!-- Add Courses Section -->
                        <label for="addCrs">Add Courses</label>
                        <input list="Courses" name="addCrs" id="addCrs">
                        <datalist id="Courses">
                            <?php foreach ($courseCodes as $course) { ?>
                            <option value="<?= htmlspecialchars($course) ?>">
                            <?php } ?>
                        </datalist>
                        <button type="button" id="add-course-btn">Add Course</button>
                        <div id="course-list"></div>
                        <input type="hidden" name="courses[]" id="courses-array">

                        <!-- Delete Courses Section -->
                        <label for="deleteCrs">Delete Courses</label>
                        <input list="DeleteCourses" name="deleteCrs" id="deleteCrs">
                        <datalist id="DeleteCourses">
                            <?php
                            $registeredCoursesQuery = mysqli_query($conn, "SELECT CourseCode FROM usercourse WHERE UserID = $user_id");
                            while ($row = mysqli_fetch_assoc($registeredCoursesQuery)) {
                                echo "<option value='" . htmlspecialchars($row['CourseCode']) . "'>";
                            }
                            ?>
                        </datalist>
                        <button type="button" id="delete-course-btn">Delete Course</button>
                        <div id="delete-course-list"></div>
                        <input type="hidden" name="delete_courses[]" id="delete-courses-array">

                        <!-- Hidden Action Field -->
                        <input type="hidden" name="action" id="action-input">

                        <button type="submit">Submit</button>
                        <button type="button" id="close-Editor">Close</button>
                    </form>
                </div>
            </div>

            <main>
                <div class="materials-container" id="course-icons-container">
                    <?php
                    // Fetch registered courses for the logged-in user
                    $userCoursesQuery = mysqli_query($conn, "SELECT CourseCode FROM usercourse WHERE UserID = $user_id");

                    // Check if the user is registered for any courses
                    if (mysqli_num_rows($userCoursesQuery) > 0) {
                        while ($row = mysqli_fetch_assoc($userCoursesQuery)) {
                            $courseCode = htmlspecialchars($row['CourseCode']); // Sanitize output

                            // Dynamically generate course cards
                            echo "
                            <div class='material-card' data-coursecode='{$courseCode}'>
                                <img src='images/{$courseCode}.png' alt='{$courseCode} Icon'>
                                <h3>{$courseCode}</h3>
                            </div>";
                        }
                    } else {
                        // Message if no courses are registered
                        echo "<p>No courses registered yet. Add courses to see them here!</p>";
                    }
                    ?>
                </div>
                <div id="course-details-container" style="display:none;">
                    <button id="close-course-details-btn">X</button>
                    <div id="course-details"></div>
                </div>

        </main>

        <footer>
            <p>&copy; 2020 CUFE Materials | Designed by:  Mohaned</p>
            <a href="#"><img src="images/icons8-google-48.png" alt="Google"></a>
            <a href="#"><img src="images/icons8-facebook-48.png" alt="Facebook"></a>
            <a href="#"><img src="images/icons8-play-button-48.png" alt="YouTube"></a>
        </footer>
    </div>
    <script>
        document.getElementById("Edit-btn").addEventListener("click", function () {
        document.getElementById("Courses-form").style.display = "flex";
        });

        document.getElementById("close-Editor").addEventListener("click", function () {
        document.getElementById("Courses-form").style.display = "none";
        });


            // Elements for Add and Delete Sections
    const addCourseBtn = document.getElementById('add-course-btn');
    const courseList = document.getElementById('course-list');
    const coursesArrayInput = document.getElementById('courses-array');
    const depInput = document.getElementById('addCrs');

    const deleteCourseBtn = document.getElementById('delete-course-btn');
    const deleteCourseList = document.getElementById('delete-course-list');
    const deleteCoursesArrayInput = document.getElementById('delete-courses-array');
    const deleteInput = document.getElementById('deleteCrs');

    const actionInput = document.getElementById('action-input');

    let selectedCourses = [];
    let deleteCourses = [];

    // Add Course
    addCourseBtn.addEventListener('click', () => {
        const course = depInput.value.trim();
        if (course && !selectedCourses.includes(course)) {
            selectedCourses.push(course);
            coursesArrayInput.value = selectedCourses.join(',');

            const courseItem = document.createElement('div');
            courseItem.innerHTML = `<span>${course}</span> <button type="button" class="remove-course-btn" data-course="${course}">X</button>`;
            courseList.appendChild(courseItem);

            depInput.value = '';
            courseItem.querySelector('.remove-course-btn').addEventListener('click', () => {
                selectedCourses = selectedCourses.filter(c => c !== course);
                coursesArrayInput.value = selectedCourses.join(',');
                courseItem.remove();
            });
        }
    });

    // Delete Course
    deleteCourseBtn.addEventListener('click', () => {
        const course = deleteInput.value.trim();
        if (course && !deleteCourses.includes(course)) {
            deleteCourses.push(course);
            deleteCoursesArrayInput.value = deleteCourses.join(',');

            const courseItem = document.createElement('div');
            courseItem.innerHTML = `<span>${course}</span> <button type="button" class="remove-course-btn" data-course="${course}">X</button>`;
            deleteCourseList.appendChild(courseItem);

            deleteInput.value = '';
            courseItem.querySelector('.remove-course-btn').addEventListener('click', () => {
                deleteCourses = deleteCourses.filter(c => c !== course);
                deleteCoursesArrayInput.value = deleteCourses.join(',');
                courseItem.remove();
            });
        }
    });

    // Set Action for Add or Delete
    document.getElementById('add-course-btn').addEventListener('click', () => {
        actionInput.value = 'add';
    });

    document.getElementById('delete-course-btn').addEventListener('click', () => {
        actionInput.value = 'delete';
    });
    
    const courseIconsContainer = document.getElementById('course-icons-container');
    const courseDetailsContainer = document.getElementById('course-details-container');
    const courseDetailsDiv = document.getElementById('course-details');
    const closeCourseDetailsBtn = document.getElementById('close-course-details-btn');

    // When a user clicks on a course icon, show course details
    courseIconsContainer.addEventListener('click', function(event) {
        const courseCard = event.target.closest('.material-card');
        if (courseCard) {
            const courseCode = courseCard.getAttribute('data-coursecode');
            console.log(courseCode);
            showCourseDetails(courseCode);
        }
    });

    // Show course details
    function showCourseDetails(courseCode) {
        // Hide course icons and show course details
        courseIconsContainer.style.display = 'none';
        courseDetailsContainer.style.display = 'block';

        // Fetch course details using AJAX
        fetch('CourseData.php?courseCode=' + courseCode)
            .then(response => response.json())
            .then(data => {
                // Display course details in the course-details div
                courseDetailsDiv.innerHTML = `
                    <h3>Course Name: ${data.CourseName}</h3>
                    <p><strong>Materials Link:</strong> <a href="${data.Materials}" target="_blank">${data.Materials}</a></p>
                    <p><strong>MD Grades:</strong> ${data.avgMD}</p>
                    <p><strong>Final Grade:</strong> ${data.AvgFinal}</p>
                    <p><strong>Syllabus:</strong> <a href="${data.Syllabus}" target="_blank">${data.Syllabus}</a></p>
                `;
            })
            .catch(error => {
                console.error('Error fetching course details:', error);
            });
    }

    // Close course details and show course icons again
    closeCourseDetailsBtn.addEventListener('click', function() {
        courseDetailsContainer.style.display = 'none';
        courseIconsContainer.style.display = 'flex';
    });

    </script>
</body>

</html>
<?php

    
?>