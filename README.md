# Data Base Project in form of Educational Resources Platform
## Overview
A free, online platform providing course materials (videos, tutorials, textbooks, question banks) to engineering students. The platform currently focuses on Cairo engineering with plans to expand to other majors. It features a robust database system that manages educational resources while enabling volunteer contributions and quality control.
<br/>**Link** : [CollageOrganizer](http://www.collegeorganizer.infy.uk/?i=1)
## Database Structure
The system implements a normalized (3NF) database with the following main entities:
- Users (Students/Volunteers/Moderators)
- Departments
- Courses
- Teachers' Information

The database design includes relationships for:
- Course enrollment
- Department management
- Major associations
- Teaching assignments

## ERD

![Image Alt](https://github.com/MohanedM7md/College-Organizer/blob/main/ERD.png?raw=true)
### Database Design Process
1. **Requirements Analysis**
   - Identified user roles
   - Gathered requirements for course data
   - Established department details
   - Implemented user authentication
## System Architecture

### Key Components
1. **Structured Data Storage**
   - Efficient organization of courses
   - Department information management
   - User data handling

2. **User Management**
   - Role-based access control
   - Student access systems
   - Moderator privileges
   - Volunteer contribution framework

3. **Course Material Management**
   - Direct material links
   - Easy access for enrolled students
   - Organized content structure

4. **Quality Control System**
   - Moderator review process
   - Content verification
   - Source credibility checks

## Installation and Setup

```bash
# Clone the repository
git clone https://github.com/MohanedM7md/College-Organizer.git

# Set up database
# Import provided SQL schema

# Configure web server
# Set up PHP environment

