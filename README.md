# alas-quadros

POS of Alas Quadros

# How to install dependencies

## Download and install Visual Studio Code

1. Download the install from `https://code.visualstudio.com/`
2. Run the installer
3. Click ALL the default configurations

## Download and install PHP

1. Download the XAMPP installer (version 8.2.12) from `https://www.apachefriends.org/download.html`
2. Run the installer to install PHP and XAMPP
3. After installation, open CMD
4. Enter `php -v` to verify if the PHP has been installed
5. Run the XAMPP control panel
6. Click Config button of Apache > php.ini
7. Search for extension=zip and uncomment by removing the ;
8. Save the file

## Download and install Composer

1. Download the installer from `https://getcomposer.org/download/`
2. Run the installer
3. Click ALL the default configurations

# How to clone GitHub repository

1. Login to GitHub
2. Ask for collaborator access to repository
3. Click `<> Code`
4. Copy the HTTPS link
5. Go to CMD
6. Change directory to Desktop
7. Enter `git clone <repo link>`
8. Right click the folder
9. Open with Visual Studio
10. Open the terminal by pressing Ctrl + J
11. Enter the command `cd alas-quadros-pos`
12. Enter the command `composer install`
13. Enter the command `npm install`

# How to run the project

1. Run the XAMPP control panel
2. Start the Apache and MySQL
3. Enter the command `cd alas-quadros-pos`
4. Enter the command `php artisan migrate`
5. Enter the command `php artisan key:generate`
6. Enter the command `php artisan serve`
7. Open a new terminal
8. Enter the command `cd alas-quadros-pos`
9. Enter the command `npm run dev`

# Project Features

1. Laravel Jetstream as Stack
2. Inertia as Jetstream stack
3. API, Dark Mode, Email Verification, and Server-side Rendering
4. Pest as Testing Framework
