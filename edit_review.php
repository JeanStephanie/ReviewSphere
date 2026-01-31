<?php
session_start();
include 'admin/config.php';

// Redirect to login page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$r_id = $_GET['r_id'];
$user_id = $_SESSION['user_id'];
$review = null;

// Fetch the review details for editing
$sql = "SELECT * FROM reviews WHERE r_id = ? AND u_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $r_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $review = $result->fetch_assoc();
} else {
    $_SESSION['edit_status'] = "unauthorized";
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $image = $review['image'];
    $video = $review['video'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_new_name = uniqid("img_", true) . '.' . $image_ext;
        $image_dest = "uploads/images/" . $image_new_name;
        move_uploaded_file($image_tmp_name, $image_dest);
        $image = $image_new_name;
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $video_tmp_name = $_FILES['video']['tmp_name'];
        $video_name = basename($_FILES['video']['name']);
        $video_ext = pathinfo($video_name, PATHINFO_EXTENSION);
        $video_new_name = uniqid("vid_", true) . '.' . $video_ext;
        $video_dest = "uploads/videos/" . $video_new_name;
        move_uploaded_file($video_tmp_name, $video_dest);
        $video = $video_new_name;
    }

    // Update the review details in the database
    $sql = "UPDATE reviews SET product_name = ?, brand = ?, model = ?, rating=?, review_text = ?, image = ?, video = ? WHERE r_id = ? AND u_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssii", $product_name, $brand, $model, $rating, $review_text, $image, $video, $r_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['edit_status'] = "success";
    } else {
        $_SESSION['edit_status'] = "error";
    }

    header("Location: reviews.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
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

        .rating-stars {
            display: inline-flex;
            flex-direction: row-reverse; /* highest star appears first visually */
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            font-size: 2rem;
            color: lightgray;
            cursor: pointer;
        }

        .rating-stars input[type="radio"]:checked ~ label {
            color: lightgray; /* ensure unchecked ones stay gray */
        }

        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: gold; /* hover effect */
        }

        .rating-stars input[type="radio"]:checked + label,
        .rating-stars input[type="radio"]:checked + label ~ label {
            color: gold; /* selected and all lower labels */
        }

    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Edit Review</h1>

        <div class="review-form">
            <h3>Edit Your Review</h3>

            <form id="reviewForm" action="edit_review.php?r_id=<?php echo $r_id; ?>" method="POST" enctype="multipart/form-data">
                <!-- Product Selection Dropdown -->
                <div class="mb-3">
                    <label for="productSelect" class="form-label">Choose a Product</label>
                    <select id="productSelect" name="product_name" class="form-select" required>
                        <option value="" disabled>Select a Product</option>
                        <optgroup label="Electronics">
                            <option value="Mobile" <?php if ($review['product_name'] == 'Mobile') echo 'selected'; ?>>Mobile</option>
                            <option value="Laptop" <?php if ($review['product_name'] == 'Laptop') echo 'selected'; ?>>Laptop</option>
                            <option value="TV" <?php if ($review['product_name'] == 'TV') echo 'selected'; ?>>TV</option>
                            <option value="Speaker" <?php if ($review['product_name'] == 'Speaker') echo 'selected'; ?>>Speaker</option>
                        </optgroup>

                        <optgroup label="Appliances">
                            <option value="Washing Machine" <?php if ($review['product_name'] == 'Washing Machine') echo 'selected'; ?>>Washing Machine</option>
                            <option value="AC" <?php if ($review['product_name'] == 'AC') echo 'selected'; ?>>AC</option>
                            <option value="Refrigerator" <?php if ($review['product_name'] == 'Refrigerator') echo 'selected'; ?>>Refrigerator</option>
                            <option value="Vacuum Cleaner" <?php if ($review['product_name'] == 'Vacuum Cleaner') echo 'selected'; ?>>Vacuum Cleaner</option>
                        </optgroup>

                        <optgroup label="Vehicles">
                            <option value="Car" <?php if ($review['product_name'] == 'Car') echo 'selected'; ?>>Car</option>
                            <option value="Scooter" <?php if ($review['product_name'] == 'Scooter') echo 'selected'; ?>>Scooter</option>
                            <option value="Bus" <?php if ($review['product_name'] == 'Bus') echo 'selected'; ?>>Bus</option>
                            <option value="Pickup Truck" <?php if ($review['product_name'] == 'Pickup Truck') echo 'selected'; ?>>Pickup Truck</option>
                        </optgroup>

                        <optgroup label="Lifestyle">
                            <option value="Mattress" <?php if ($review['product_name'] == 'Mattress') echo 'selected'; ?>>Mattress</option>
                            <option value="Pillow" <?php if ($review['product_name'] == 'Pillow') echo 'selected'; ?>>Pillow</option>
                            <option value="Bedsheet" <?php if ($review['product_name'] == 'Bedsheet') echo 'selected'; ?>>Bedsheet</option>
                            <option value="Lighting" <?php if ($review['product_name'] == 'Lighting') echo 'selected'; ?>>Lighting</option>
                        </optgroup>

                        <optgroup label="Beauty">
                            <option value="Skincare" <?php if ($review['product_name'] == 'Skincare') echo 'selected'; ?>>Skincare</option>
                            <option value="Haircare" <?php if ($review['product_name'] == 'Haircare') echo 'selected'; ?>>Haircare</option>
                            <option value="Makeup" <?php if ($review['product_name'] == 'Makeup') echo 'selected'; ?>>Makeup</option>
                            <option value="Grooming Devices" <?php if ($review['product_name'] == 'Grooming Devices') echo 'selected'; ?>>Grooming Devices</option>
                        </optgroup>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" id="brand" name="brand" class="form-control" value="<?php echo htmlspecialchars($review['brand']); ?>" required />
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" id="model" name="model" class="form-control" value="<?php echo htmlspecialchars($review['model']); ?>" required />
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="rating-stars">
                        <?php for ($i = 5; $i >= 1; $i--) { ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>"
                                <?php if ($review['rating'] == $i) echo 'checked'; ?>>
                            <label for="star<?php echo $i; ?>">★</label>
                        <?php } ?>
                    </div>
                    <div id="ratingError" class="text-danger mt-1" style="display: none;">Please select a rating before submitting.</div>
                </div>

                <div class="mb-3">
                    <label for="reviewText" class="form-label">Review</label>
                    <textarea id="reviewText" name="review_text" class="form-control" rows="3"><?php echo htmlspecialchars($review['review_text']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="reviewImage" class="form-label">Upload an Image</label>
                    <input type="file" id="reviewImage" name="image" class="form-control" accept="image/*" />
                    <?php if (!empty($review['image'])) { ?>
                        <img src="uploads/images/<?php echo $review['image']; ?>" class="img-fluid rounded mt-2" style="max-width: 200px; height: 200px;">
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <label for="reviewVideo" class="form-label">Upload a Video</label>
                    <input type="file" id="reviewVideo" name="video" class="form-control" accept="video/*" />
                    <?php if (!empty($review['video'])) { ?>
                        <video width="100%" controls class="mt-2">
                            <source src="uploads/videos/<?php echo $review['video']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php } ?>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary">Update Review</button>
                <a href="reviews.php" class="btn btn-secondary ms-2">Cancel</a>
            </form>

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