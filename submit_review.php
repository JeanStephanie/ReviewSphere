<?php
session_start();
include 'admin/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to submit a review.'); window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $u_id = $_SESSION['user_id'];  // Get user id from session
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);

     // ✅ ADD THIS VALIDATION RIGHT HERE:
     if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo "<script>alert('Please provide a valid rating between 1 and 5'); window.history.back();</script>";
        exit;
    }

    // File Upload
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $video_name = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];

    $image_target = "uploads/images/" . basename($image_name);
    $video_target = "uploads/videos/" . basename($video_name);

    if (!empty($image_name)) {
        move_uploaded_file($image_tmp, $image_target);
    }
    if (!empty($video_name)) {
        move_uploaded_file($video_tmp, $video_target);
    }

    // Insert query
    $sql = "INSERT INTO reviews (u_id, product_name, brand, model, rating, review_text, image, video, upload_date)
            VALUES ('$u_id', '$product_name', '$brand', '$model', '$rating', '$review_text', '$image_name', '$video_name', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Review submitted successfully!'); window.location.href='reviews.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- HTML Form -->
<h2>Submit Review</h2>
<form action="submit_review.php" method="POST" enctype="multipart/form-data">
    <label>Product Name:</label><br>
    <input type="text" name="product_name" required><br><br>

    <label>Brand:</label><br>
    <input type="text" name="brand" required><br><br>

    <label>Model:</label><br>
    <input type="text" name="model" required><br><br>

    <label>Rating (1-5):</label><br>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <label>Review Text:</label><br>
    <textarea name="review_text"></textarea><br><br>

    <label>Upload Image:</label><br>
    <input type="file" name="image"><br><br>

    <label>Upload Video:</label><br>
    <input type="file" name="video"><br><br>

    <input type="submit" value="Submit Review">
</form>
