<?php
session_start();
include 'admin/config.php';

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    // Sanitize input
    $uid = mysqli_real_escape_string($conn, $uid);

    $query = "SELECT * FROM users WHERE u_id = $uid";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
    }
} else {
    // Redirect to login or show error
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReviewSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/png">
</head>

<body>
    <header>
    <div class="logo-wrapper">
        <img src="./images/logo.png" alt="Logo" class="logo-img">
        <span class="logo-text">ReviewSphere</span>
    </div>
        
        <div>
            <nav>
                <ul>
                    <li>
                        <a href="#">Home</a>
                        <div class="dropdown-content">
                            <a href="./home/aboutus.html">About Us</a>
                            <a href="./home/privacy.html">Privacy Policy</a>
                            <a href="./home/terms.html">Terms and Conditions</a>
                        </div>
                    </li>

                    <li>
                        <a href="#contact">Contact Form</a>
                    </li>

                    <li>
                        <a href="queries.php">My Queries</a>
                    </li>

                    <li>
                        <a href="reviews.php">Reviews</a>
                    </li>

                    <!-- Profile Icon -->
                    <li class="nav-item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fas fa-user-circle" style="font-size: 30px; color: #fff;"></i>
                        </a>
                    </li> 
                </ul>
            </nav>
        </div>
    </header>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Profile Edit Form -->
                    <form method="POST" action="update-profile.php">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="fname" value="<?php echo $user['fname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lname" value="<?php echo $user['lname']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>

                    <div class="mt-3">
                        <!-- Log Out Button -->
                        <a href="logout.php" class="btn btn-secondary w-100">Log Out</a>
                    </div>

                    <!-- Delete Account Button (Triggers Confirmation Modal) -->
                    <div class="mt-2">
                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Account Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Account Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                Are you sure you want to delete your account? This action cannot be undone.
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="delete-account.php" class="btn btn-danger">Yes, Delete</a>
            </div>
            
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="category">
            <img src="./images/electronics.jpg" alt="Electronics">
            <h3>Electronics</h3>
            <div class="dropdown-menu">
                <a href="Electronics/mobile.html">Mobiles</a>
                <a href="Electronics/laptop.html">Laptops</a>
                <a href="Electronics/tv.html">TV's</a>
                <a href="Electronics/speaker.html">Speakers</a>
            </div>
        </div>

        <div class="category">
            <img src="./images/appliance.jpg" alt="Appliances">
            <h3>Appliances</h3>
            <div class="dropdown-menu">
                <a href="Appliances/washingMachine.html">Washing Machine </a>
                <a href="Appliances/ac.html">AC</a>
                <a href="Appliances/refrigerator.html">Refrigerator</a>
                <a href="Appliances/vacuum.html">Vacuum Cleaner</a>
            </div>
        </div>

        <div class="category">
            <img src="./images/vehicles.jpg" alt="Vehicles">
            <h3>Vehicles</h3>
            <div class="dropdown-menu">
                <a href="Vehicles/car.html">Car</a>
                <a href="Vehicles/scooter.html">Scooter</a>
                <a href="Vehicles/bus.html">Bus</a>
                <a href="Vehicles/pickupTrucks.html">Pickup Trucks</a>
            </div>
        </div>

        <div class="category">
            <img src="./images/lifestyle.jpg" alt="Lifestyle">
            <h3>Lifestyle</h3>
            <div class="dropdown-menu">
                <a href="Lifestyle/mattress.html">Mattresses</a>
                <a href="Lifestyle/pillows.html">Pillows</a>
                <a href="Lifestyle/bedsheets.html">Bedsheets</a>
                <a href="Lifestyle/lighting.html">Lighting</a>
            </div>
        </div>

        <div class="category">
            <img src="./images/beauty.jpg" alt="Beauty">
            <h3>Beauty</h3>
            <div class="dropdown-menu">
                <a href="Beauty/skincare.html">Skincare</a>
                <a href="Beauty/haircare.html">Haircare</a>
                <a href="Beauty/makeup.html">Makeup</a>
                <a href="Beauty/groomingDevice.html">Grooming Devices</a>
            </div>
        </div>
    </div>

    <main>
        
        <!--welcome-->
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary" style="background: linear-gradient(to bottom, #00457c,  #80d0ff);">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
              <h1 class="display-3 fw-bold text-white">Welcome to ReviewSphere!</h1>
              <h3 class="fw-normal text-muted mb-3 text-white-override">Your go-to platform for unbiased reviews and insightful guides</h3> 
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
        
        <!-- Grid of Cards -->
        <div class="grid">
            <div class="card">
                <img src="images/camera.jpg" alt="Camera">
                <div class="card-content">
                    <h3><a href="cards/camera.html">Top 5 cameras you should consider if you are a first time photographer</a></h3>
                </div>
            </div>
            <div class="card">
                <img src="images/car.jpg" alt="Car">
                <div class="card-content">
                    <h3><a href="cards/cars.html">Top 5 best budget cars with 6 airbags</a></h3>
                </div>
            </div>
            <div class="card">
                <img src="images/vacuum.jpg" alt="Robotic Vacuum">
                <div class="card-content">
                    <h3><a href="cards/vacuums.html">6 Best robotic vacuums of 2024</a></h3>
                </div>
            </div>
            <div class="card">
                <img src="images/mattress.jpg" alt="Mattress">
                <div class="card-content">
                    <h3><a href="cards/mattress.html">5 top tips for buying your first mattress</a></h3>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-container" id="contact">
            <h2 class="text-center" style="font-weight:600;">Have Questions? <br> Reach Out!</h2>
            <form action="submit-query.php" method="POST" class="contact-form">
                <div class="mb-3">
                    <label for="name" class="form-label" style="color: #00457c;">Name<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #00457c;">Email<span class="text-danger"> *</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label" style="color: #00457c;">Subject (Optional)</label>
                    <input type="text" class="form-control" id="subject" name="subject">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label" style="color: #00457c;">Message<span class="text-danger"> *</span></label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </form>
        </div>

    </main>

    <footer>
        <p>&copy; 2025 ReviewSphere. All rights reserved.</p>
    </footer>

    <script src="scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    

</body>

</html>