# Random xkcd comic emailer

This project is built using HTML, CSS, JavaScript, PHP, and MySQL for storing the data.

## Requirements

-   PHP 8 and above
-   Google account

## Configuration

After cloning the repository you need to add your database details in the `configs/database.php` file.

```php
// configs/database.php
define('DB_HOST', 'YOUR_HOST_NAME');
define('DB_USER', 'YOUR_DATABASE_USER');
define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD');
define('DB_NAME', 'YOUR_DATABASE_NAME');
```

After that you need to go to [google scripts](https://script.google.com) and create new project.

-   In the newly created project now go to `code.gs` file and paste all the content from `email/code.gs` file.
-   Also create two new files (`comic.html` and `token.html`) and past their content in them.
-   Now deploy the project (create new web app) with the default setting (make sure to change the access to anyone if not anyone) after that copy the app url and open the `src/email.php`. On line 34 change the url to your url

## Folder Structure

-   `assets` directory contains all the static `CSS` and `JavaScript` file required by the project
-   `components` directory contains the UI components used in the project
-   `configs` directory contains database configuration files
-   `email` directory contains the email templates and the google app script file
-   `src` directory contains the user and email classes
-   `index.php` is the landing page of the project
-   `about.php` is the about page of the project
-   `getting-started.php` is the page where user enter their info
-   `token-verification.php` is the page for verifying the user's email address by using token
-   `success.php` is the page where user user reaches after successfully subscribing/unsubscribing
-   `cron.php` is used for sending comics to the subscribed users every 5 minutes

## Usage

Run `index.php` in your browser.
