# Assignment2_Authentication
[CS 5339] Secure Web-Based Systems

[Assignment created by: Dr. Luc Longpre at UTEP]

The web site has three types of users: visitors, regular users, and
administrators. Information about regular users and administrators will be
stored in a MySQL database. Visitors have access to public information
without needing to go through authentication. Access to web pages will
depend on which type of user attempts to load the page.

Pages
The website has the following pages:
1. a main page named mainpage.php
2. a sign in page named signin.php
3. a page accessible by all signed-in users named user.php
4. a page accessible only by signed-in administrators named admin.php
5. a file that connects to the database called connect_database.php
6. a file that processes the sign-out page for the user or admin called sign_out.php
7. a page that displays the list of users that is only accessible by the admin called list_of_users.php
8. a page that allows the administrator to register users into the database called insert_users.php
