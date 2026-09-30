# CIHE ClubConnect — ICT203 Model Full-Stack Application

A teacher/model solution for the **University club/association** scenario in ICT203 Assessment 3.

## Rubric-aligned features

* Secure authentication with **Admin** and **Standard User**
* Password hashing using PHP `password\\\_hash()` / `password\\\_verify()`
* Server-side role-based access control
* CRUD for **Events** and **Announcements**
* Event search, category filter and pagination
* Client-side HTML/JS validation + server-side PHP validation
* Responsive mobile-first UI and semantic/labelled controls
* PDO prepared statements and safe HTML output
* CSRF protection on state-changing forms
* Audit log plus created/updated-by timestamps
* Local rule/keyword **Smart Help Assistant**
* Responsible-use explanation and safe fallback
* MySQL schema, sample data setup and testing plan

## Requirements

* PHP 8+
* MySQL 8+ or compatible MariaDB
* Apache (XAMPP recommended)

## Installation with XAMPP

1. Copy the folder `CIHE\\\_ClubConnect\\\_Model` into `C:\\\\xampp\\\\htdocs\\\\`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open phpMyAdmin and import `database.sql`.
4. Confirm `config/config.php` matches your MySQL credentials. XAMPP defaults are `root` with a blank password.
5. Open `http://localhost/CIHE\\\_ClubConnect\\\_Model/setup.php` once.
6. After setup succeeds, delete or rename `setup.php`.
7. Open `http://localhost/CIHE\\\_ClubConnect\\\_Model/`.

## Demo accounts

* Admin: `admin@clubconnect.test` / `Admin123!`
* Standard User: `member@clubconnect.test` / `Member123!`

Change all demonstration passwords before any real deployment.

## Application structure

```text
CIHE\\\_ClubConnect\\\_Model/
├── admin/logs.php
├── announcements/
├── assets/css/style.css
├── assets/js/app.js
├── config/
├── docs/
├── events/
├── includes/
├── database.sql
├── dashboard.php
├── help.php
├── index.php
├── login.php
├── logout.php
└── setup.php
```

## Security design

The model uses prepared statements, output escaping, password hashing, session regeneration after login, role checks on protected pages, CSRF tokens on state-changing forms, validation and POST-only deletion. Production deployment should additionally use HTTPS, secure/HttpOnly/SameSite cookie configuration, environment variables for DB secrets, rate limiting, security headers, logging/monitoring and backups.

## Smart Help Assistant

Smart Help is intentionally simple and transparent. It converts the user's question to lowercase, checks curated keyword groups, scores matching rules and returns the response belonging to the best match. If no rule matches, it returns a safe fallback.

It does **not**:

* send questions to ChatGPT, Gemini, Claude or another public AI API;
* automatically create/edit/delete application records;
* claim to understand topics outside the curated rules.

This gives users review/control and avoids sending personal information to an external AI service.

## Deployment

For assessment demonstration, deploy to a PHP/MySQL host, import `database.sql`, run `setup.php` once, then remove it. Update hard-coded `/CIHE\\\_ClubConnect\\\_Model/` base paths if the deployed folder name differs.

**Public deployment URL:** `\\\[INSERT ACTUAL DEPLOYMENT URL]`

**GitHub repository:** `\\\[INSERT ACTUAL REPOSITORY URL]`

These cannot be truthfully pre-filled in a model package because they depend on the actual hosting and repository used by the group/teacher.

## Evidence

See `docs/TEST\\\_PLAN.md`, `docs/RUBRIC\\\_ALIGNMENT.md`, and `docs/AI\\\_FEATURE.md`.

## AI assistance statement

This package is a teacher/model reference produced with AI assistance. Any student use should follow the institution's assessment rules and accurately declare AI assistance. Students should understand and be able to explain all submitted code and design choices.

