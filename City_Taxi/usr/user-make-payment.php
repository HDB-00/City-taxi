<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

// Fetch booking details
if (isset($_GET['b_id']) && isset($_GET['amount'])) {
    $b_id = $_GET['b_id'];
    $amount = urldecode($_GET['amount']);
} else {
    $error_message = "Missing required parameters.";
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['make_payment'])) {
        // Process payment (implement your payment gateway logic here)
        // Update booking status in the database to indicate payment
        $update_query = "UPDATE tms_bookings SET b_status = 'Paid' WHERE b_id = ?";
        $stmt = $mysqli->prepare($update_query);
        $stmt->bind_param('i', $b_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['success_msg'] = "Payment successful! Thank you for your payment.";
        } else {
            $_SESSION['error_msg'] = "Payment failed. Please try again.";
        }
        
        // Redirect to the manage bookings page
        header("Location: user-manage-booking.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("vendor/inc/head.php");?>

<body id="page-top">
    <?php include("vendor/inc/nav.php");?>

    <div id="wrapper">
        <?php include("vendor/inc/sidebar.php");?>
        <div id="content-wrapper">
            <div class="container-fluid">
                <h2 class="mb-4 text-center">Payment Gateway</h2>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php else: ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $amount; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="card_number">Card Number</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="cvv">CVV</label>
                                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                                    </div>
                                </div>
                                <div class="form-group mb-5">
                                    <button type="submit" name="make_payment" class="btn btn-primary mr-2">Make Payment</button>
                                    <a href="user-manage-booking.php" class="btn btn-secondary">Cancel Payment</a>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php include("vendor/inc/footer.php");?>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <?php include("vendor/inc/logout.php");?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vendor/js/sb-admin.min.js"></script>
</body>
</html>
