# Project and Thesis Management System

This is a comprehensive web application designed to streamline the management of academic projects and theses at a university. It provides a centralized platform for students, supervisors, research cells, and administrators to manage the entire lifecycle of a project, from proposal to completion. The application also includes a module for managing industrial proposals, fostering collaboration between students and industry partners.

## Key Features

- **User Authentication:** Secure registration and login for all user roles. New user registrations require admin approval.
- **Role-Based Access Control:** Differentiated dashboards and permissions for Students, Supervisors, Co-Supervisors, Research Cells, and Admins.
- **Project Proposal Submission:** Students can create and submit detailed project proposals, including title, problem statement, motivation, and course details.
- **Project Approval Workflow:** A multi-level approval process where proposals are reviewed by Supervisors, Research Cells, and Administrators.
- **Project and Thesis Management:** Track the status of projects (e.g., pending, approved, rejected, completed).
- **Group Formation:** Students can form project groups, with a configurable maximum number of members.
- **Industrial Proposals:** A dedicated module for students to submit proposals for industrial projects, connecting them with partner companies.
- **Supervisor and Co-Supervisor Assignment:** Admins can assign supervisors and co-supervisors to projects.
- **User Management:** Admins have full control to manage users, including approving new accounts.
- **Academic Structure Management:** Admins can manage departments and research cells.
- **Company Management:** Admins can manage a list of partner companies for industrial collaborations.
- **System Settings:** Admins can configure application-wide settings, such as the maximum number of members per project.

## User Roles

The application defines the following user roles:

- **Admin:** Has full access to all system modules. Responsibilities include managing users, approving new accounts, managing academic structures (departments, research cells), overseeing the project approval process, and configuring system settings.
- **Research Cell:** Responsible for reviewing and approving project proposals based on their alignment with the university's research goals and available resources.
- **Supervisor:** Academic staff who supervise student projects. They can review and approve proposals for projects they are assigned to supervise.
- **Co-Supervisor:** Assists the main supervisor in guiding students. They can be assigned to projects by an admin.
- **Student:** Can submit project and industrial proposals, form project groups with other students, and track the status of their submissions.

## Installation Guide

Follow these steps to set up the project on your local machine.

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- A database server (e.g., MySQL, MariaDB)

### Steps

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd <project-directory>
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

4.  **Create your environment file:**
    ```bash
    cp .env.example .env
    ```

5.  **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Configure your database:**
    Open the `.env` file and update the `DB_*` variables with your database credentials.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

7.  **Run database migrations and seed the database:**
    This command will create the necessary tables and populate them with initial data, including the default user accounts listed below.
    ```bash
    php artisan migrate:refresh --seed
    ```

8.  **Build frontend assets:**
    ```bash
    npm run dev
    ```
    Or, for production:
    ```bash
    npm run build
    ```

9.  **Start the development server:**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

## Default Login Credentials

After seeding the database, you can use the following default accounts to log in and test the application. The password for all accounts is `password`.

| Role          | Email                  |
|---------------|------------------------|
| Admin         | `admin@example.com`    |
| Research Cell | `rcell@example.com`    |
| Supervisor    | `full@example.com`     |
| Supervisor    | `manik@example.com`    |
| Supervisor    | `abid@example.com`     |
| Co-Supervisor | `cosupervisor1@example.com` |
| Co-Supervisor | `cosupervisor2@example.com` |
| Student       | `student1@example.com` |
| Student       | `student2@example.com` |
| Student       | `student3@example.com` |
| Student       | `student4@example.com` |
