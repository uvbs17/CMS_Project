# College Management System ERP

## Overview

Welcome to the College Management System ERP! This system is designed to streamline and automate various administrative and academic processes within a college. It includes features for student, faculty, and department administration, making it a comprehensive solution for managing college operations.

## Features

- **Student Login**: Secure login for students to access their profiles, view grades, and manage their schedules.
- **Faculty Login**: Faculty members can log in to manage classes, upload materials, and track student progress.
- **Department Admin Login**: Department administrators can oversee departmental activities, manage faculty, and handle student issues.
- **Class Management**: Create, update, and manage class schedules and assignments.
- **Time Table Management**: Efficiently manage and update class timetables.
- **Attendance Management**: Track and manage student attendance records.
- **Admission Management**: Handle the entire admission process from application to enrollment.
- **Course Management**: Manage course details, syllabi, and materials.
- **Fee Management**: Manage student fees, generate invoices, and track payments.
- **Notifications**: Send notifications and updates to students and faculty.
- **Results**: Shows Pass/Fail for any particular student.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/cms_project.git
   ```

2. **Navigate to the project directory**:
   ```bash
   cd college-management-system-erp
   ```

3. **Set up WAMP server**:
   - Download and install [WAMP](http://www.wampserver.com/en/).
   - Start WAMP server and ensure Apache and MySQL services are running.

4. **Create a database**:
   - Open phpMyAdmin (usually accessible at `http://localhost/phpmyadmin`).
   - Create a new database named `cms`.

5. **Import the database schema**:
   - In phpMyAdmin, select the `cms` database.
   - Import the provided SQL file (`database/cms.sql`).

6. **Configure the application**:
   - Open `config.php` and update the database configuration:
     ```php
     define('DB_SERVER', 'localhost');
     define('DB_USERNAME', 'root');
     define('DB_PASSWORD', '');
     define('DB_DATABASE', 'cms');
     ```

7. **Start the application**:
   - Open your web browser and navigate to `http://localhost/cms_project`.

## Usage

- **Students**: Log in to view your profile, check your timetable, and track your attendance.
- **Faculty**: Log in to manage your classes, upload materials, and track student progress.
- **Department Admins**: Log in to oversee departmental activities, manage faculty, and handle student,class, timetable issues.

## Contributing

We welcome contributions from the community! Please follow these steps to contribute:

1. **Fork the repository**.
2. **Create a new branch**:
   ```bash
   git checkout -b feature/your_feature_name
   ```
3. **Make your changes and commit them**:
   ```bash
   git commit -m "Add your commit message"
   ```
4. **Push to the branch**:
   ```bash
   git push origin feature/your_feature_name
   ```
5. **Open a pull request on GitHub**.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Contact

For any questions or suggestions, please raise issue or comment.