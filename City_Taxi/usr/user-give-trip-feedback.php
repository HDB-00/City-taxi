<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid = $_SESSION['u_id'];
  $b_id = $_GET['b_id']; // Get the booking ID from the URL

  // Fetch booking details
  $ret = "SELECT b.*, v.v_category, v.v_reg_no 
          FROM tms_bookings b
          JOIN tms_vehicle v ON b.v_id = v.v_id
          WHERE b.b_id = ?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $b_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $booking_details = $res->fetch_object();

  //Add Trip Feedback
  if(isset($_POST['give_trip_feedback']))
    {
            $tf_feedback_text = $_POST['tf_feedback_text'];
            
            $query = "INSERT INTO tms_trip_feedback (b_id, tf_feedback_text) VALUES (?, ?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('is', $b_id, $tf_feedback_text);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Trip Feedback Submitted";
                }
                else 
                {
                    $err = "Please Try Again Later";
                }
            }
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php');?>

<body id="page-top">
    <!--Start Navigation Bar-->
    <?php include("vendor/inc/nav.php");?>
    <!--Navigation Bar-->
    
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("vendor/inc/sidebar.php");?>
        <!--End Sidebar-->
        <div id="content-wrapper">
            
            <div class="container-fluid">
                <?php if(isset($succ)) {?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ;?>!", "success");
                    },
                    100);
                </script>

                <?php } ?>
                <?php if(isset($err)) {?>
                <!--This code for injecting an alert-->
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err;?>!", "error");
                    },
                    100);
                </script>

                <?php } ?>
                
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="user-dashboard.php">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Trip Feedback</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Give Trip Feedback
                    </div>
                    <div class="card-body">
                        <!--Add Trip Feedback Form-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="pickup_location">Pickup Location</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $booking_details->pickup_location;?>" id="pickup_location" name="pickup_location">
                            </div>
                            <div class="form-group">
                                <label for="return_location">Drop-off Location</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $booking_details->return_location;?>" id="return_location" name="return_location">
                            </div>
                            <div class="form-group">
                                <label for="b_date">Booking Date</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $booking_details->b_date;?>" id="b_date" name="b_date">
                            </div>
                            <div class="form-group">
                                <label for="v_category">Vehicle Type</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $booking_details->v_category;?>" id="v_category" name="v_category">
                            </div>
                            <div class="form-group">
                                <label for="v_reg_no">Vehicle Registration</label>
                                <input type="text" required readonly class="form-control" value="<?php echo $booking_details->v_reg_no;?>" id="v_reg_no" name="v_reg_no">
                            </div>
                            <div class="form-group">
                                <label for="tf_feedback_text">Your Feedback</label>
                                <textarea class="form-control" id="tf_feedback_text" name="tf_feedback_text" rows="5" maxlength="255" required></textarea>
                            </div>
                            <button type="submit" name="give_trip_feedback" class="btn btn-success">Submit Trip Feedback</button>
                        </form>
                        <!-- End Form-->
                    </div>
                </div>

                <hr>
                
                <!-- Sticky Footer -->
                <?php include("vendor/inc/footer.php");?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

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

        <!--INject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>
        
</body>
</html>
