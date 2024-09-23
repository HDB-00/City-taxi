<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();

if (isset($_GET['u_id'])) {
    $u_id = $_GET['u_id'];

    // Update booking status to 'Hire Ended'
    $query = "UPDATE tms_user SET u_car_book_status = 'Hire Ended' WHERE u_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $u_id);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the driver-manage-booking page
    header("Location: driver-manage-booking.php");
    exit;
}
?>
