<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['u_id'];
  //Update User
  if (isset($_POST['update_user'])) {
    $u_id = $_GET['u_id'];
    $u_fname = $_POST['u_fname'];
    $u_lname = $_POST['u_lname'];
    $u_phone = $_POST['u_phone'];
    $u_license_or_ID = $_POST['u_license_or_ID'];
    $u_addr = $_POST['u_addr'];
    $u_email = $_POST['u_email'];

    $query = "UPDATE tms_user SET u_fname=?, u_lname=?, u_phone=?, u_license_or_ID=?, u_addr=?, u_email=? WHERE u_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssi', $u_fname, $u_lname, $u_phone, $u_license_or_ID, $u_addr, $u_email, $u_id);
    $stmt->execute();

    if ($stmt) {
        $succ = "User Updated";
    } else {
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
                         <?php
            $aid=$_GET['u_id'];
            $ret="select * from tms_user where u_id=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i',$aid);
            $stmt->execute() ;//ok
            $res=$stmt->get_result();
            //$cnt=1;
            while($row=$res->fetch_object())
        {
        ?>
                         
                         <form method="POST">
                         <div class="form-group">
                                <label for="First Name">First Name</label>
                                <input type="text" value="<?php echo $row->u_fname; ?>" required class="form-control" id="First Name" name="u_fname">
                            </div>
                            <div class="form-group">
                                <label for="Last Name">Last Name</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_lname; ?>" id="Last Name" name="u_lname">
                            </div>
                            <div class="form-group">
                                <label for="Contact">Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_phone; ?>" id="Contact" name="u_phone">
                            </div>
                            <div class="form-group">
                                <label for="License or ID">License or ID</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_license_or_ID; ?>" id="License or ID" name="u_license_or_ID">
                            </div>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_addr; ?>" id="Address" name="u_addr">
                            </div>

                            <div class="form-group">
                                <label for="Email address">Email address</label>
                                <input type="email" value="<?php echo $row->u_email; ?>" class="form-control" name="u_email">
                            </div>

                             <button type="submit" name="update_user" class="btn btn-success">Update User</button>
                         </form>
                         <!-- End Form-->
                         <?php }?>
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