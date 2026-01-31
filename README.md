ReviewSphere - A Comprehensive Product Review Website

ReviewSphere is a full stack product review website built using HTML, CSS, JavaScript, Bootstrap, jQuery, PHP and MySQL.
It allows users to register, log in, submit product reviews, and interact with reviews, while an admin panel enables managing users, reviews and queries.

This project was developed as part of my BCA final semester project.


Features

User Features

* User registration & login system
* Secure session-based authentication
* Submit product reviews with:
  * Product category & subcategory
  * Rating
  * Review text
  * Image / video upload
* View all product reviews
* Profile section to view and update user details
* Delete own account with confirmation
* Forgot password (direct reset without email)


Admin Panel Features

* Separate admin login system
* Dashboard with sidebar navigation
* View registered users
* View and delete reviews
* Filter reviews by product category
* Manage contact form queries
* Reply to user queries (replies visible to users)
* Secure access to admin-only pages


Product Categories

* Electronics – Mobiles, Laptops, TVs, Speakers
* Appliances – Washing Machine, AC, Refrigerator, Vacuum Cleaner
* Vehicles – Cars, Bikes, Scooters, Pickup Trucks
* Lifestyle – Mattresses, Pillows, Bedsheets, Lightings
* Beauty – Skincare, Haircare, Makeup, Grooming Devices


Technologies Used

Frontend

* HTML5
* CSS3
* JavaScript
* Bootstrap5
* jQuery

Backend

* PHP 
* MySQL

Tools

* XAMPP
* Visual Studio Code
* Git & GitHub

Database Design

Tables Used

* users – stores user account and profile details
* admin – admin login credentials
* reviews – product reviews with user association
* votes – likes/votes on reviews
* queries – contact form queries and admin replies


Installation & Setup

1. Clone the repository:

   bash
   git clone https://github.com/yourusername/ReviewSphere.git

2. Move the project folder to:

   xampp/htdocs/

3. Start Apache and MySQL from XAMPP Control Panel

4. Create a database named:

   reviewsphere

5. Import the SQL file into phpMyAdmin

6. Configure database connection in:

   admin/config.php

7. Open in browser:

   http://localhost/ReviewSphere


Security Considerations

* Passwords are stored using hashing
* Sessions used for authentication
* Admin panel protected from unauthorized access
* Users cannot edit/delete other users’ reviews


Screenshots


Author

Jean Stephanie