<?php
session_start();

$deleteAlert = "";
if (isset($_SESSION['delete_status'])) {
    $status = $_SESSION['delete_status'];

    if ($status == "success") {
        $deleteAlert = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Review deleted successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } elseif ($status == "error") {
        $deleteAlert = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error while deleting the review.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } elseif ($status == "unauthorized") {
        $deleteAlert = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            Unauthorized access! You can only delete your own reviews.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } elseif ($status == "invalid") {
        $deleteAlert = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            Invalid request.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    unset($_SESSION['delete_status']);
}

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/png">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 20px;
            color: #00457c;
        }

        .review-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .review-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .review-card h5 {
            margin: 0;
            font-size: 1.2rem;
        }

        .review-card p {
            font-size: 1rem;
            color: #555;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product-item {
            width: 23%;
            margin-bottom: 15px;
        }

        .rating-stars {
            direction: rtl;
            unicode-bidi: bidi-override;
            display: inline-flex;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
        }

        .rating-stars input[type="radio"]:checked ~ label {
            color: gold;
        }

        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: gold;
        }

        /* Add some hover effects for buttons */
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary:active {
            background-color: #004085;
            border-color: #003769;
        }

        .review-filter {
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <?php echo $deleteAlert; ?>

    <div class="container">
        <h1 class="text-center">Product Reviews</h1>

        <div class="product-list" id="product-list"></div>

        <div class="review-form">
            <h3>Submit a Review</h3>

            <form id="reviewForm" action="submit_review.php" method="POST" enctype="multipart/form-data">
                <!-- Product Selection Dropdown -->
                <div class="mb-3">
                    <label for="productSelect" class="form-label">Choose a Product</label>
                    <select id="productSelect" name="product_name" class="form-select" required>
                        <option value="" disabled selected>Select a Product</option>
                        <optgroup label="Electronics">
                            <option value="Mobile">Mobile</option>
                            <option value="Laptop">Laptop</option>
                            <option value="TV">TV</option>
                            <option value="Speaker">Speaker</option>
                        </optgroup>

                        <optgroup label="Appliances">
                            <option value="Washing Machine">Washing Machine</option>
                            <option value="AC">AC</option>
                            <option value="Refrigerator">Refrigerator</option>
                            <option value="Vacuum Cleaner">Vacuum Cleaner</option>
                        </optgroup>

                        <optgroup label="Vehicles">
                            <option value="Car">Car</option>
                            <option value="Scooter">Scooter</option>
                            <option value="Bus">Bus</option>
                            <option value="Pickup Truck">Pickup Truck</option>
                        </optgroup>

                        <optgroup label="Lifestyle">
                            <option value="Mattress">Mattress</option>
                            <option value="Pillow">Pillow</option>
                            <option value="Bedsheet">Bedsheet</option>
                            <option value="Lighting">Lighting</option>
                        </optgroup>

                        <optgroup label="Beauty">
                            <option value="Skincare">Skincare</option>
                            <option value="Haircare">Haircare</option>
                            <option value="Makeup">Makeup</option>
                            <option value="Grooming Devices">Grooming Devices</option>
                        </optgroup>
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" id="brand" name="brand" class="form-control" required />
                </div>
            
                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" id="model" name="model" class="form-control" required />
                </div>
            
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="rating-stars">
                        <input type="radio" name="rating" id="star5" value="5"><label for="star5">&#9733;</label>
                        <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
                        <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
                        <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
                        <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
                    </div>
                    <div id="ratingError" class="text-danger mt-1" style="display: none;">
                        Please select a rating before submitting your review.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="reviewText" class="form-label">Review</label>
                    <textarea id="reviewText" name="review_text" class="form-control" rows="3"></textarea>
                </div>
            
                <div class="mb-3">
                    <label for="reviewImage" class="form-label">Upload an Image</label>
                    <input type="file" id="reviewImage" name="image" class="form-control" accept="image/*" />
                </div>
            
                <div class="mb-3">
                    <label for="reviewVideo" class="form-label">Upload a Video</label>
                    <input type="file" id="reviewVideo" name="video" class="form-control" accept="video/*" />
                </div>
            
                <button type="submit" id="submitBtn" class="btn btn-primary">Submit Review</button>
                <button type="button" id="cancelEditBtn" class="btn btn-secondary ms-2" style="display: none;">Cancel Edit</button>
            </form>
            
        </div>

        <div class="review-filter">
            <h3>Filter Reviews</h3>
            <form method="GET" action="">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="filterProductSelect" class="form-label">Filter by Product</label>
                        <select id="filterProductSelect" name="product" class="form-select">
                            <option value="" selected>All Products</option>
                            <optgroup label="Electronics">
                                <option value="Mobile">Mobile</option>
                                <option value="Laptop">Laptop</option>
                                <option value="TV">TV</option>
                                <option value="Speaker">Speaker</option>
                            </optgroup>

                            <optgroup label="Appliances">
                                <option value="Washing Machine">Washing Machine</option>
                                <option value="AC">AC</option>
                                <option value="Refrigerator">Refrigerator</option>
                                <option value="Vacuum Cleaner">Vacuum Cleaner</option>
                            </optgroup>

                            <optgroup label="Vehicles">
                                <option value="Car">Car</option>
                                <option value="Scooter">Scooter</option>
                                <option value="Bus">Bus</option>
                                <option value="Pickup Truck">Pickup Truck</option>
                            </optgroup>

                            <optgroup label="Lifestyle">
                                <option value="Mattress">Mattress</option>
                                <option value="Pillow">Pillow</option>
                                <option value="Bedsheet">Bedsheet</option>
                                <option value="Lighting">Lighting</option>
                            </optgroup>

                            <optgroup label="Beauty">
                                <option value="Skincare">Skincare</option>
                                <option value="Haircare">Haircare</option>
                                <option value="Makeup">Makeup</option>
                                <option value="Grooming Devices">Grooming Devices</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="filterRating" class="form-label">Choose a Rating</label>
                        <select id="filterRating" name="rating" class="form-select">
                            <option value="" selected>All Ratings</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <h3 class="mt-5">Customer Reviews</h3>
        <div id="reviews-list">
            <?php
            include 'admin/config.php';

            // Get filter criteria
            $product = isset($_GET['product']) ? $_GET['product'] : '';
            $rating = isset($_GET['rating']) ? $_GET['rating'] : '';

            // Build SQL query with filters
            $sql = "SELECT r.*, u.fname, u.lname 
                    FROM reviews r
                    JOIN users u ON r.u_id = u.u_id
                    WHERE 1=1";

            if (!empty($product)) {
                $sql .= " AND r.product_name = '" . mysqli_real_escape_string($conn, $product) . "'";
            }

            if (!empty($rating)) {
                $sql .= " AND r.rating = " . intval($rating);
            }

            $sql .= " ORDER BY r.upload_date DESC";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Convert rating to stars
                    $stars = str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']);
            ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($row['product_name']); ?>
                                <small class="text-muted">(<?php echo htmlspecialchars($row['brand']); ?> - <?php echo htmlspecialchars($row['model']); ?>)</small>
                            </h5>
                            <p class="card-subtitle mb-2 text-muted">
                            By: <?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?> | Uploaded On: <?php echo date("d M Y", strtotime($row['upload_date'])); ?>
                            </p>

                            <span style="color: gold; font-size: 1.2rem;"><?php echo $stars; ?></span>

                            <p class="card-text"><?php echo nl2br(htmlspecialchars($row['review_text'])); ?></p>

                            <?php if (!empty($row['image'])) { ?>
                                    <img src="uploads/images/<?php echo $row['image']; ?>" class="img-fluid rounded" style="max-width: 200px; height: 200px;">
                            <?php } ?><br>

                            <?php if (!empty($row['video'])) { ?>
                                    <video width="200px" height="200px" controls>
                                        <source src="uploads/videos/<?php echo $row['video']; ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            <?php } ?>

                            <div class="mt-3 d-flex justify-content-end gap-2">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['u_id']) { ?>
                                <a href="edit_review.php?r_id=<?php echo $row['r_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_review.php?r_id=<?php echo $row['r_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?');">Delete</a>
                            <?php } ?>
                        </div>
                        </div>
                    </div>
            <?php
                } 
            } else {
                echo "<div class='alert alert-info text-center'>No reviews found.</div>";
            }
            ?>
        </div>

    </div>

    <!-- JavaScript to handle rating validation -->
    <script>
        const reviewForm = document.getElementById("reviewForm");
        const ratingError = document.getElementById("ratingError");

        reviewForm.addEventListener("submit", function(event) {
            const ratingSelected = document.querySelector('input[name="rating"]:checked');

            if (!ratingSelected) {
                event.preventDefault(); // Stop form from submitting
                ratingError.style.display = "block"; // Show error message
            } else {
                ratingError.style.display = "none"; // Hide error if already selected
            }
        });
        
    </script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>