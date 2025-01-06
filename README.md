# Engineering Educational Resources Platform


https://github.com/user-attachments/assets/c9809a30-eed0-4266-893d-4fbf2bb0b65c


## Overview
A free, online platform providing course materials (videos, tutorials, textbooks, question banks) to engineering students. The platform currently focuses on Cairo engineering with plans to expand to other majors. It features a robust database system that manages educational resources while enabling volunteer contributions and quality control.

## Features
- **Free Access**: Students can access curated materials through email registration
- **Course Materials Management**: Centralized storage for various educational resources
- **Quality Control**: Moderated content ensuring accuracy and relevance
- **Scalable Architecture**: Designed to accommodate multiple universities and majors
- **User Role System**: Support for students, volunteers, and moderators

## Database Structure
The system implements a normalized (3NF) database with the following main entities:
- Users (Students/Volunteers/Moderators)
- Departments
- Courses
- Teachers' Information

### Entity Relationship Diagram (ERD)
The database design includes relationships for:
- Course enrollment
- Department management
- Major associations
- Teaching assignments

Key entities in the system:
1. User:
   - ID
   - Name (first and last)
   - Email
   - Password
   - Role

2. Departments:
   - Name
   - Code
   - Connected to courses through "Has Courses" relationship

3. Courses:
   - Course_Code
   - Course_Name
   - Syllabus
   - Materials Link
   - Average Grade
   - Final
   - MD
   - Quizzes

4. Teachers' Information:
   - Full Name
   - Phone Number
   - Email
   - Degree

## ERD

![9d40d7b2-1be3-48b8-bb58-b4ecea5d2f71](https://github.com/user-attachments/assets/e046e2a6-7473-431f-bd8b-19d2a9d0b7e0)
### Database Design Process
1. **Requirements Analysis**
   - Identified user roles
   - Gathered requirements for course data
   - Established department details
   - Implemented user authentication

2. **Conceptual Design**
   - Developed comprehensive ERD
   - Created scalable structure
   - Planned for future expansion

3. **Logical Design**
   - Implemented relational database schema
   - Applied normalization (3NF)
   - Eliminated multi-valued attributes
   - Removed partial dependencies

4. **Implementation**
   - Utilized PHP with built-in SQL
   - Established web interface connections
   - Created data interaction systems

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
