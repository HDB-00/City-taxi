<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];

  // Include PHPMailer
  require '../vendor/autoload.php';  // Changed this line

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  // Function to send confirmation email
  function sendWelcomeEmail($userEmail, $userName, $userPassword) {
      $mail = new PHPMailer(true);
      try {
          // Server settings
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'hndteamwattala@gmail.com';
          $mail->Password   = 'brax ysds ffrx ojer'; // App Password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;

          // Recipients
          $mail->setFrom('hndteamwattala@gmail.com', 'City Taxi');
          $mail->addAddress($userEmail, $userName);

          // Content
          $mail->isHTML(true);
          $mail->Subject = 'Welcome to Our Service';
          $mail->Body    = "Hello $userName,<br><br>
                            Thank you for registering with our service. Your account has been successfully created.<br><br>
                            Your login details:<br>
                            Email: $userEmail<br>
                            Password: $userPassword<br><br>";

          $mail->send();
          return true;
      } catch (Exception $e) {
          error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
          return false;
      }
  }

  //Add User
  if(isset($_POST['add_user']))
    {
            $u_fname=$_POST['u_fname'];
            $u_lname = $_POST['u_lname'];
            $u_phone=$_POST['u_phone'];
            $u_license_or_ID=$_POST['u_NIC'];
            $u_addr=$_POST['u_addr'];
            $u_email=$_POST['u_email'];
            $u_pwd = password_hash($_POST['u_pwd'], PASSWORD_DEFAULT);

            $query="INSERT INTO tms_user (u_fname, u_lname, u_phone, u_license_or_ID, u_addr, u_email, u_pwd) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('sssssss', $u_fname, $u_lname, $u_phone, $u_license_or_ID, $u_addr, $u_email, $u_pwd);
            $stmt->execute();
            if($stmt)
            {
                // Send confirmation email
                $plainTextPassword = $_POST['u_pwd']; // Get the plain text password
                $emailSent = sendWelcomeEmail($u_email, $u_fname . ' ' . $u_lname, $plainTextPassword);
                if($emailSent) {
                    $succ = "User Added and Confirmation Email Sent";
                } else {
                    $succ = "User Added but Failed to Send Confirmation Email";
                }
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
                        swal("Failed!", "<?php echo $err;?>!", "Failed");
                    },
                    100);
                </script>

                <?php } ?>
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Users</a>
                    </li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
                <hr>
                
                <div class="card">
                    <div class="card-header">
                        Add User
                    </div>
                    <div class="card-body">
                        <!--Add User Form-->
                        <form method="POST">
                            <div class="form-group">
                                <label for="First Name">First Name</label>
                                <input type="text" required class="form-control" id="First Name" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="Last Name">Last Name</label>
                                <input type="text" class="form-control" id="Last Name" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="Contact">Contact</label>
                                <input type="text" class="form-control" id="Contact" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="NIC No">License or ID</label>
                                <input type="text" class="form-control" id="NIC No" name="u_NIC">
                            </div>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" id="Address" name="u_addr">
                            </div>

                            <div class="form-group" style="display:none">
                                <label for="Category">Category</label>
                                <input type="text" class="form-control" id="Category" value="User" name="u_category">
                            </div>

                            <div class="form-group">
                                <label for="Email address">Email address</label>
                                <input type="email" class="form-control" name="u_email">
                            </div> 
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" name="u_pwd" id="Password">
                            </div>

                            <button type="submit" name="add_user" class="btn btn-success">Add User</button>
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
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModal">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="operator-logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Page level plugin JavaScript-->
        <script src="vendor/chart.js/Chart.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="vendor/js/sb-admin.min.js"></script>
        
        <!-- Demo scripts for this page-->
        <script src="vendor/js/demo/datatables-demo.js"></script>
        <script src="vendor/js/demo/chart-area-demo.js"></script>
        <!--INject Sweet alert js-->
        <script src="vendor/js/swal.js"></script>

 </body>
 </html>