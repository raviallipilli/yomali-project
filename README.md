# Simple Website Traffic Tracker

# Author - Ravi Allipilli

# Project Time Spent - 5 hours

## Overview
The goal of this project is to develop a simple website traffic tracker that monitors unique visits to web pages. It involves tracking visits, storing visit data, and displaying statistics in a user-friendly interface.

## Components
1. **JavaScript Tracker**: Collects visit data from client websites.
2. **PHP Server-Side Application**: Handles data storage and retrieval.
3. **MySQL Database**: Stores visit data.
4. **User Interface**: Displays the number of unique visits per page for a given time period.

## Project Prerequisites
- Clone the repository.
- Install Composer and run:
    ```bash
    composer install
    composer update
    ```
- PHP version 7.4.
- Microservice Slim framework version 2.
- MySQL for local storage and testing.
- XAMPP/WAMP or Docker (this project uses WAMP64 server).

## Setup

### Database
1. **Create a MySQL database**:
    ```sql
    DROP TABLE IF EXISTS `visits`;
    CREATE TABLE IF NOT EXISTS `visits` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `page_name` varchar(100) DEFAULT NULL,
        `url` varchar(255) DEFAULT NULL,
        `entry_timestamp` datetime NOT NULL,
        `exit_timestamp` datetime NOT NULL,
        `ip` varchar(45) DEFAULT NULL,
        `user_agent` varchar(255) DEFAULT NULL,
        `createdate` datetime NOT NULL,
        `updatedate` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=712 DEFAULT CHARSET=latin1;
    ```

### PHP
1. **Files**:
    - **Model**: `visits.php`
    - **Controller**: `track-info.php` (HTTP GET/POST method - retrieves data from the database using form submit).
    - **Controller**: `track.php` (HTTP POST method - saves data into the database).
    - **View**: `base.dashboard.html`

2. **Database Connection**:
    - Update the database connection details in both `track.php` and `track-info.php`.

### JavaScript Tracker
1. **Include the Tracker**:
    - Add the following script to your web pages. Place it within the `<header>` tag of your HTML files (e.g., in `base.dashboard.html`).

## Note:
We can isolate the script into a separate JS file, but we need your data from the session; hence, it is placed in the header of the base file.

## Usage
1. **Tracking Visits**:
    - Once the project is set up on the local machine, use the local server (e.g., http://yomali.localhost). Ensure the WAMP server is running in the background to interact with the database and the server.
    - There are a few pages already designed in this project to test different pages, the number of visits per page, and the time spent on each page.
    - After navigating through a few pages, you can track visits in the database or identify them in the front-end view on the Traffic Tracking section in the menu.
    - By default, the page uses the current date and the time span is 24 hours. You can filter the results by changing the filters to different dates and times.
    - There is an option to filter by User.
    - You can also view data by different roles (e.g., admin and non-admin).

2. **Viewing Visits**:
    - Navigate to `http://yomali.localhost/track-info` to view the unique visits per page. It uses GET to fetch the data from the database, but for each visit of the pages, it uses POST to insert the data in the database.

## Conclusion
1. **Readme File**: This file, with instructions on how to set up and use the project. ✔️
2. **Source Code**:
    - JavaScript tracker. ✔️
    - Server-side user interface and tracking logic (`track.php`, `track-info.php`, `base.dashboard.html`). ✔️
3. **Database Schema**:
    - `yomali_db.sql` for setting up the MySQL database, located inside the `db-scripts` folder. ✔️
4. **Video Screen Recording**:
    - A walkthrough of the codebase, data flow, and a demonstration of the tracker in action, tracking multiple pages and displaying results for different time periods. ✔️
