<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

if(isset($_GET['b_id'])) {
    $b_id = $_GET['b_id'];
    
    // First, check if the booking belongs to the logged-in user and is in 'Pending' status
    $check_query = "SELECT * FROM tms_bookings WHERE b_id = ? AND u_id = ? AND b_status = 'Pending'";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param('ii', $b_id, $aid);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if($result->num_rows > 0) {
        // If the booking is valid, proceed with cancellation
        $cancel_query = "UPDATE tms_bookings SET b_status = 'Cancelled' WHERE b_id = ?";
        $cancel_stmt = $mysqli->prepare($cancel_query);
        $cancel_stmt->bind_param('i', $b_id);
        
        if($cancel_stmt->execute()) {
            $succ = "Booking cancelled successfully";
        } else {
            $err = "Unable to cancel booking. Please try again later.";
        }
    } else {
        $err = "Invalid booking or you don't have permission to cancel this booking.";
    }
} else {
    $err = "Invalid request. Booking ID not provided.";
}

// Redirect back to the manage bookings page with a success or error message
if(isset($succ)) {
    header("Location: user-manage-booking.php?success=".urlencode($succ));
} else {
    header("Location: user-manage-booking.php?error=".urlencode($err));
}
exit();
?>
