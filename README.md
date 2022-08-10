# Random xkcd comic emailer

This project is built using HTML, CSS, JavaScript, PHP, and MySQL for storing the data.

The live demo link for the app: https://emaaail.herokuapp.com/index.php

## Requirements

-   PHP 8 and above
-   Google account

## Configuration

After cloning the repository you need to go to [google scripts](https://script.google.com) and create new project.

-   In the newly created project now go to `code.gs` file and paste all the content from `email/code.gs` file.
-   Also create two new files (`comic.html` and `token.html`) and past their content in them.
-   Now deploy the project (create new web app) with the default setting (make sure to change the access to anyone if not anyone) after that copy the app url and add as environmental variable.

After that you need to configure environmental variables for the project.

_Note: as I am using remotemysql as my database the database name and user are same for me; you can change this by going to `configs/database.php` file._

```env
DB_HOST=<your-database-host>
DB_PASSWORD=<your-database-password>
DB_USER=<your-database-user>
GOOGLE_APP_SCRIPT_URL=<your-google-app-script-url>
CRON_SECRET=<your-cron-secret> # you can set this value to any secret you like
```

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
-   `cron.php` is used for sending comics to the subscribed users every 5 minutes. This page only accepts the get request which contains the `cron-secret` as its parameter. If the `cron-secret` and env variable `CRON_SECRET` are same only then the emails are sent.

## Usage

Run `index.php` in your browser.
