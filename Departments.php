<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUFE Material Page</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .courses-container {
            display: none;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 2rem;
        }

        .course-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #007BFF, #1D83CE);
            color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
        }

        .course-details {
            display: none;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            text-align: left;
        }

        .close-btn {
            display: none;
            position: absolute;
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .department-card {
    display: flex;
    flex-direction: column;
    cursor: pointer !important;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4c6daf, #8a81c7);
    color: white;
    text-align: center;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    padding: 20px;
    transition: transform 0.3s ease;
}
    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            <img src="images/CUFElogo.png" alt="CUFE Logo">
            <h1>CUFE Material Page</h1>
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
            <div class="main-container">
                <div id="departments-container" st>
                    <?php
                    include("MyDbConnection.php");

                    $departmentsQuery = mysqli_query($conn, "SELECT Dcode FROM departments");
                    while ($row = mysqli_fetch_assoc($departmentsQuery)) {
                        $dcode = htmlspecialchars($row['Dcode']);
                        echo "
                        <div class='department-card' data-dcode='{$dcode}'>
                            
                            <h3>{$dcode}</h3>
                        </div>";
                    }
                    mysqli_close($conn);
                    ?>
                </div>
                <div id="course-details-container" style="display:none;">
                    
                    <div id="course-details"></div>
                </div>
                <button id="close-btn" class="close-btn">X</button>
                <div id="courses-container" class="courses-container"></div>
            </div>
        </main>

        <footer>
            <p>&copy; 2020 CUFE Material Page | Designed by: Mohaned </p>
            <a href="#"><img src="images/icons8-google-48.png" alt="Google"></a>
            <a href="#"><img src="images/icons8-facebook-48.png" alt="Facebook"></a>
            <a href="#"><img src="images/icons8-play-button-48.png" alt="YouTube"></a>
        </footer>
    </div>

    <script>
        const departmentsContainer = document.getElementById('departments-container');
        const coursesContainer = document.getElementById('courses-container');
        const closeBtn = document.getElementById('close-btn');

        // Handle department click
        document.querySelectorAll('.department-card').forEach(card => {
            card.addEventListener('click', () => {
                const dcode = card.getAttribute('data-dcode');
                fetchCourses(dcode);
            });
        });

        // Fetch courses for the selected department
        function fetchCourses(dcode) {
            fetch(`fetch_courses.php?dcode=${dcode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayCourses(data.courses);
                    } else {
                        alert('No courses found for this department.');
                    }
                })
                .catch(err => console.error('Error fetching courses:', err));
        }

        // Display courses
        function displayCourses(courses) {
            departmentsContainer.style.display = 'none';
            coursesContainer.innerHTML = '';
            coursesContainer.style.display = 'grid';
            closeBtn.style.display = 'block';

            courses.forEach(course => {
                const courseCard = document.createElement('div');
                courseCard.className = 'course-card';
                courseCard.innerHTML = `
                    <img src="images/${course.CourseCode}.png" alt="${course.CourseCode}">
                    <h3>${course.CourseCode}</h3>
                `;
                courseCard.addEventListener('click', () => showCourseDetails(course));
                coursesContainer.appendChild(courseCard);
            });
        }

        // Show course details

        const courseDetailsContainer = document.getElementById('course-details-container');
        const courseDetailsDiv = document.getElementById('course-details');
        function showCourseDetails(course) {
            coursesContainer.style.display = 'none';
            courseDetailsContainer.style.display = 'block'
            fetch('CourseData.php?courseCode=' + course.CourseCode)
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

        // Add course (to be implemented)

        // Handle close button
        closeBtn.addEventListener('click', () => {
            coursesContainer.style.display = 'none';
            courseDetailsContainer.style.display = 'none'
            departmentsContainer.style.display = 'grid';
            closeBtn.style.display = 'none';
        });
    </script>
</body>

</html>
