<?php
  session_start();
  include('vendor/inc/config.php');
  include('vendor/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['a_id'];
  //Add vehicle
  if(isset($_POST['upate_veh']))
    {
            $v_id = $_GET['v_id'];
            $v_name=$_POST['v_name'];
            $v_reg_no = $_POST['v_reg_no'];
            $v_pass_no = $_POST['v_pass_no'];
            $v_category=$_POST['v_category'];
            $v_cost=$_POST['v_cost'];
            $v_status=$_POST['v_status'];
            $d_id=$_POST['d_id'];
            $v_dpic=$_FILES["v_dpic"]["name"];
            move_uploaded_file($_FILES["v_dpic"]["tmp_name"],"../vendor/img/".$_FILES["v_dpic"]["name"]);
            $query="update tms_vehicle set v_name=?, v_reg_no=?, v_pass_no=?, v_category=?, v_cost=?, v_dpic=?, v_status=?, d_id=? where v_id = ?";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('sssssssii', $v_name, $v_reg_no, $v_pass_no, $v_category, $v_cost, $v_dpic, $v_status, $d_id, $v_id);
            $stmt->execute();
                if($stmt)
                {
                    $succ = "Vehicle Updated";
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

     <!--Navigation Bar-->
     <?php include("vendor/inc/nav.php");?>
     
     
     <div id="wrapper">

         <!-- Sidebar -->
         <?php include("vendor/inc/sidebar.php");?>
         
         <div id="content-wrapper">

             <div class="container-fluid">
                 <?php if(isset($succ)) {?>
                 <!--code for an alert-->
                 <script>
                 setTimeout(function() {
                         swal("Success!", "<?php echo $succ;?>!", "success");
                     },
                     100);
                 </script>

                 <?php } ?>
                 <?php if(isset($err)) {?>
                 
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
                         <a href="#">Vehicles</a>
                     </li>
                     <li class="breadcrumb-item active">Update Vehicle</li>
                 </ol>
                 <hr>
                 <div class="card">
                     <div class="card-header">
                         Update Vehicle
                     </div>
                     <div class="card-body">
                         <!--Form-->
                         <?php
            $aid=$_GET['v_id'];
            $ret="select * from tms_vehicle where v_id=?";
            $stmt= $mysqli->prepare($ret) ;
            $stmt->bind_param('i',$aid);
            $stmt->execute() ;
            $res=$stmt->get_result();
            while($row=$res->fetch_object())
        {
        ?>
                         
                         <form method="POST" enctype="multipart/form-data">
                             <div class="form-group">
                                 <label for="Vehicle Name">Vehicle Name</label>
                                 <input type="text" value="<?php echo $row->v_name;?>" required class="form-control" id="Vehicle Name" name="v_name">
                             </div>
                             <div class="form-group">
                                 <label for="Vehicle Registration Number">Vehicle Registration Number</label>
                                 <input type="text" value="<?php echo $row->v_reg_no;?>" class="form-control" id="Vehicle Registration Number" name="v_reg_no">
                             </div>
                             <div class="form-group">
                                 <label for="Number of Seats">Number of Seats</label>
                                 <input type="text" value="<?php echo $row->v_pass_no;?>" class="form-control" id="Number of Seats" name="v_pass_no">
                             </div>

                             <div class="form-group">
                                 <label for="Driver">Driver</label>
                                 <select class="form-control" name="d_id" id="Driver">
                                     <?php
                                     $drivers = $mysqli->query("SELECT * FROM tms_driver");
                                     while($driver = $drivers->fetch_object()) {
                                         $selected = ($driver->d_id == $row->d_id) ? 'selected' : '';
                                         echo "<option value='{$driver->d_id}' {$selected}>{$driver->d_fname} {$driver->d_lname}</option>";
                                     }
                                     ?>
                                 </select>
                             </div>

                             <div class="form-group">
                                 <label for="Vehicle Category">Vehicle Category</label>
                                 <select class="form-control" name="v_category" id="Vehicle Category">
                                    <option <?php if($row->v_category == 'Bus') echo 'selected'; ?>>Bus</option>
                                    <option <?php if($row->v_category == 'Sedan') echo 'selected'; ?>>Sedan</option>
                                    <option <?php if($row->v_category == 'SUV') echo 'selected'; ?>>SUV</option>
                                    <option <?php if($row->v_category == 'Van') echo 'selected'; ?>>Van</option>
                                 </select>
                             </div>

                             <div class="form-group">
                                 <label for="Vehicle Cost (Per 1 Km)">Vehicle Cost (Per 1 Km)</label>
                                 <input type="text" value="<?php echo $row->v_cost;?>" class="form-control" id="Vehicle Cost (Per 1 Km)" name="v_cost">
                             </div>

                             <div class="form-group">
                                 <label for="Vehicle Status">Vehicle Status</label>
                                 <select class="form-control" name="v_status" id="Vehicle Status">
                                     <option <?php if($row->v_status == 'Available') echo 'selected'; ?>>Available</option>
                                     <option <?php if($row->v_status == 'Booked') echo 'selected'; ?>>Busy</option>
                                 </select>
                             </div>
                             
                             <div class="card form-group" style="width: 30rem">
                                 <img src="../vendor/img/<?php echo $row->v_dpic;?>" class="card-img-top">
                                 <div class="card-body">
                                     <h5 class="card-title">Vehicle Picture</h5>
                                     <input type="file" class="btn btn-success" id="exampleInputEmail1" name="v_dpic">
                                 </div>
                             </div>
                             <hr>
                             <button type="submit" name="upate_veh" class="btn btn-success">Update Vehicle</button>
                         </form>
                        
                         <?php }?>
                     </div>
                 </div>

                 <hr>


                 <!-- Footer -->
                 <?php include("vendor/inc/footer.php");?>

             </div>
             

         </div>
         
         
         <!-- Scroll to Top Button-->
         <a class="scroll-to-top rounded" href="#page-top">
             <i class="fas fa-angle-up"></i>
         </a>

         <!-- Logout code-->
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
                         <a class="btn btn-danger" href="admin-logout.php">Logout</a>
                     </div>
                 </div>
             </div>
         </div>
         
         <!-- Bootstrap-->
         <script src="vendor/jquery/jquery.min.js"></script>
         <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

         <!-- Core plugin JavaScript code-->
         <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

         <!-- Page level plugin JavaScript code-->
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