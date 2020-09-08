# Basic-Graphical-Based-Password
Helps to avoid shoulder surfing and keeping the account password secure by using a Color-Wheel to enter password.

# Tecnologies 
  * PHP-Laravel Framework
  * Vue JS
  * MySQL
  * Adobe Illustrator (for making the color wheel)
  * Regex

# Interface
On the first page (`127.0.0.1/`) are login/signup buttons. The user can login (after successful signup) by entering his password form the color wheel. 

### Signup
When clicked on signup, the user is taken to a very basic signup form, there are 2 things that are important while signing-up 
  * First, the user must enter a valid password, accepted passwords are in the range of `a-h (case sensitive)` and `1-8`.
  * Second, the user must remember his password color from the drop-down in the signup-form, this color will be used later in the Color-Wheel to enter the user password.
  
### Login
When clicked, will ask for user's email (to be verified by the system), if done successfully, a password-color-wheel will be displayed on the screen from which the user can enter his password. This is done by spining the wheel and pressing inner/outer value buttons, the values will be added in accordance to the password color user selected at the time of signup.

# Project Installation
 * Download the project and unzip. 
 * Next, the `code` folder must be placed into the `htdocs` folder.
 * Database (in `database` folder) must be imported into MySQL for the code to function properly, Database username and password are the default ones for Xampp.
 * To run the project, use command `php artisan serve` in the current directory with cmd and go to the server url, which will take you to the `home` page. The process after that is already explained above.
 * **Note:-** I have placed all the components pre-compiled in the code folder.

# Project Demo
A demo video is available on [https://youtu.be/1gb2ZOhl4eM]. Previews are also available on this repo in `Previews` Folder

# More Info
The project was created 10 months before today(2/9/2020) on Laravel-6.0 version.

The main aim of this project was for me to understand ***regex*** and ***using graphics for security*** in a web application. This was my seventh project on web-development.
