<h2>ReviewSphere - A Comprehensive Product Review Website</h2>

ReviewSphere is a full stack product review website built using HTML, CSS, JavaScript, Bootstrap, jQuery, PHP and MySQL.
It allows users to register, log in, submit and view product reviews, and ask queries, while an admin panel enables managing users, reviews and queries.

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
* View all product reviews by filtering reviews by product category
* Profile section to view and update user details
* Delete own account with confirmation
* Forgot password (direct reset without email)


Admin Panel Features

* Separate admin login system
* Dashboard with sidebar navigation
* View and delete registered users
* View and delete reviews
* Filter reviews by product category
* Manage contact form queries
* Reply to user queries (replies visible to users)


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

Database Design

Tables Used

* users – stores user account and profile details
* admin – admin login credentials
* reviews – product reviews with user association
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

<details> <summary><strong>User Side</strong></summary><br>
<p><b>User Sign Up</b></p>
 <p>To login, the user must first create an account by signing up.</p>
<img src="https://github.com/user-attachments/assets/0c9f142b-4954-47fa-9f21-49a25e1e6c50" width="500"/><br><br>
 
<p><b>Login</b></p>
<p>This is the login page. After logging in, the user can access the website.</p>
<img src="https://github.com/user-attachments/assets/e14f9e33-c471-4012-a5cf-48fc9b4c41a3" width="500"/><br><br>

<p><b>Main Dashboard</b></p>
<img src="https://github.com/user-attachments/assets/4b1c12b5-aec7-4b55-afc7-759fb8c00bc4" width="500"/><br>
<img src="https://github.com/user-attachments/assets/ff4fa374-eaf5-4a09-9f5b-cad1b70e3125" width="500"/><br>
<img src="https://github.com/user-attachments/assets/0ada93bb-ec5e-429e-ab38-af4fb6781cdc" width="500"/><br>
<img src="https://github.com/user-attachments/assets/dfb808ef-594d-47b0-a42a-ad229e2d9c08" width="500"/><br>
<img src="https://github.com/user-attachments/assets/712e8eb5-a00c-4db0-b7c1-57f68177b96d" width="500"/><br>
<img src="https://github.com/user-attachments/assets/95cd5ab3-bf29-48af-8861-9b26597029b7" width="500"/><br><br>


<p><b>My Queries</b></p>
<p>This section allows users to see the admin’s replies to their queries.</p>
<img src="https://github.com/user-attachments/assets/8b11ed4c-ca39-474f-a504-0f5de8f4dc89" width="500"/><br><br>

<p><b>Reviews</b></p>
<p>This section allows users to upload and read reviews. Only the user who uploaded the review can edit or delete it.</p>
<img src="https://github.com/user-attachments/assets/61e20683-f6f0-417d-84a5-bed7413f034c" width="500"/><br>
<img src="https://github.com/user-attachments/assets/8dae0e5a-6f50-40d1-b7a1-784c197e8231" width="500"/><br>
<img src="https://github.com/user-attachments/assets/66f8004a-a3b6-41ad-b5ec-6d6f8848c059" width="500"/><br><br>

<p><b>Profile</b></p>
<p>Here, the users can change their first and last name, log out, or delete their account.</p>
<img src="https://github.com/user-attachments/assets/597849db-8558-4633-bdc6-18e82cda956d" width="500" /><br><br>

<p><b>Electronics → Mobile</b></p>
<img src="https://github.com/user-attachments/assets/08b628dc-ae96-44a6-9477-2dd683c0ca73" width="500"/><br>
<img src="https://github.com/user-attachments/assets/2c68132f-d07c-4fe8-95d6-d495883c962a" width="500"/><br>
<img src="https://github.com/user-attachments/assets/c43e49b0-6100-4a16-b20d-1bff236948aa" width="500"/><br>
<img src="https://github.com/user-attachments/assets/e9911253-d2e2-4751-8a01-a2aec39e5d7e" width="500"/><br>
<img src="https://github.com/user-attachments/assets/c20ae0e0-429d-4ce1-9d72-4f45fe7faa4e" width="500"/><br>
<img src="https://github.com/user-attachments/assets/49b7ed9d-d0d9-42a2-9aa1-d0a76825e663" width="500"/><br>
<img src="https://github.com/user-attachments/assets/d15d918d-f50e-46f7-b6fe-c74c0100aeda" width="500"/><br>
<img src="https://github.com/user-attachments/assets/e09c8e17-85ee-44b7-9da3-6b18ea9f72ce" width="500"/><br>
<img src="https://github.com/user-attachments/assets/e0ef96bb-ef8a-446b-ab82-1526a33736cb" width="500"/>
</details>


<details> <summary><strong>Admin Panel</strong></summary>
<p><b>Admin Login</b></p>
<p>After logging in, the admin can manage users, reviews, and respond to queries.</p>
<img src="https://github.com/user-attachments/assets/3e240851-f7f9-47a0-8d2f-5daad1c7e01a" width="500"/><br>
 
<p><b>Dashboard</b></p>
<img src="https://github.com/user-attachments/assets/d05c63d0-42bd-42ee-8936-6e4845cd5a22" width="500"/><br>

<p><b>Users</b></p>
<img src="https://github.com/user-attachments/assets/87ddc0cf-4009-4da7-b8a4-263927ef82f6" width="500"/><br>

<p><b>Reviews</b></p> 
<img src="https://github.com/user-attachments/assets/0b0db66d-6e66-4746-89db-cd31c2016329" width="500"/><br>

<p><b>Queries & Replies</b></p>
<img src="https://github.com/user-attachments/assets/5cc39b31-d96d-43ec-a42d-177ab073730a" width="500"/>
</details>



Author

Jean Stephanie F
