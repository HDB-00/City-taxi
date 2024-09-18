<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['a_id'];

// Add Booking
if (isset($_POST['book_vehicle'])) {
    $u_id = $_GET['u_id'];
    $v_id = $_POST['v_id'];
    $d_id = $_POST['d_id'];
    $b_date = $_POST['b_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $b_status = 'Pending'; // Set status to 'Pending' automatically

    // Fetch vehicle cost
    $cost_query = "SELECT v_cost FROM tms_vehicle WHERE v_id = ?";
    $cost_stmt = $mysqli->prepare($cost_query);
    $cost_stmt->bind_param('i', $v_id);
    $cost_stmt->execute();
    $cost_result = $cost_stmt->get_result();
    $cost_row = $cost_result->fetch_assoc();
    $v_cost = $cost_row['v_cost'];
    $cost_stmt->close();

    // Use your Google Maps API key here
    $apiKey = 'AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk';
    
    $distance = calculateDistance($pickup_location, $return_location, $apiKey);
    
    if ($distance !== null) {
        // Calculate hire cost based on distance and vehicle-specific rate
        $hire = $distance * $v_cost;
    } else {
        // Handle error - couldn't calculate distance
        $err = "Unable to calculate distance. Please check the addresses and try again.";
        // You might want to exit the script or handle this error appropriately
    }

    // Prepare SQL query for tms_bookings table
    $query = "INSERT INTO tms_bookings (u_id, v_id, d_id, b_date, pickup_location, return_location, distance, hire, b_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iiissssds', $u_id, $v_id, $d_id, $b_date, $pickup_location, $return_location, $distance, $hire, $b_status);
    $stmt->execute();

    if ($stmt) {
        // Update vehicle status
        $update_query = "UPDATE tms_vehicle SET v_status='Busy' WHERE v_id=?";
        $update_stmt = $mysqli->prepare($update_query);
        $update_stmt->bind_param('i', $v_id);
        $update_stmt->execute();
        $update_stmt->close();

        $succ = "Booking Added and Vehicle Status Updated to Busy";
    } else {
        $err = "Please Try Again Later";
    }

    $stmt->close();
}

function calculateDistance($origin, $destination, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $apiKey;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    if (isset($data['rows'][0]['elements'][0]['distance']['value'])) {
        // Convert meters to kilometers
        return $data['rows'][0]['elements'][0]['distance']['value'] / 1000;
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <!-- Navigation Bar -->
    <?php include("vendor/inc/nav.php"); ?>
    

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('vendor/inc/sidebar.php'); ?>
        

        <div id="content-wrapper">

            <div class="container-fluid">
                
                <?php if (isset($succ)) { ?>
                <!-- code for a success alert -->
                <script>
                setTimeout(function() {
                        swal("Success!", "<?php echo $succ; ?>", "success");
                    },
                    100);
                </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                
                <script>
                setTimeout(function() {
                        swal("Failed!", "<?php echo $err; ?>", "error");
                    },
                    100);
                </script>
                <?php } ?>

                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Bookings</a>
                    </li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
                <hr>
                <div class="card">
                    <div class="card-header">
                        Add Booking
                    </div>
                    <div class="card-body">
                        <!--  User Form -->
                        <?php
                        $aid = $_GET['u_id'];
                        $ret = "SELECT * FROM tms_user WHERE u_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
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
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" value="<?php echo $row->u_addr; ?>" id="Address" name="u_addr">
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Category">Vehicle Category</label>
                                <select class="form-control" name="v_category" id="v_category" required>
                                    <option value="">Select Vehicle Category</option>
                                    <?php
                                    $query = "SELECT DISTINCT v_category FROM tms_vehicle WHERE v_status='Available'";
                                    $result = $mysqli->query($query);
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['v_category'] . "'>" . $row['v_category'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Vehicle Registration">Vehicle Registration Number</label>
                                <select class="form-control" name="v_id" id="v_id" required>
                                    <option value="">Select Vehicle Registration</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="driver_name">Driver</label>
                                <input type="text" class="form-control" id="driver_name" name="driver_name" readonly>
                                <input type="hidden" id="d_id" name="d_id">
                            </div>
                            <div class="form-group">
                                <label for="Booking Date">Booking Date</label>
                                <input type="date" class="form-control" id="b_date" name="b_date" required>
                            </div>
                            <input type="hidden" id="v_cost" name="v_cost">
                            <div class="form-group">
                                <label for="pickup_location">Pickup Point</label>
                                <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                            </div>
                            <div class="form-group">
                                <label for="return_location">Drop Point</label>
                                <input type="text" class="form-control" id="return_location" name="return_location" required>
                            </div>
                            <div class="form-group">
                                <label for="distance">Total Distance (km)</label>
                                <input type="number" step="0.01" class="form-control" id="distance" name="distance" readonly>
                            </div>
                            <div class="form-group">
                                <label for="hire">Total Hire</label>
                                <input type="number" step="0.01" class="form-control" id="hire" name="hire" readonly>
                            </div>
                            <button type="submit" name="book_vehicle" class="btn btn-success">Confirm Booking</button>
                        </form>
                        <?php } ?>
                    </div>
                </div>

                <hr>

                <!-- Footer -->
                <?php include("vendor/inc/footer.php"); ?>

            </div>

        </div>
        

        
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

       
        <script src="vendor/js/sb-admin.min.js"></script>

        <!-- JavaScript to handle dynamic dropdown population -->
        <script>
        $(document).ready(function() {
            // Load vehicle registration numbers based on vehicle category
            $('#v_category').change(function() {
                var v_category = $(this).val();
                $.ajax({
                    url: "get_vehicle_regno.php",
                    method: "POST",
                    data: { v_category: v_category },
                    success: function(data) {
                        $('#v_id').html(data);
                    }
                });
            });

            // Load driver details based on vehicle registration number
            $('#v_id').change(function() {
                var v_id = $(this).val();
                $.ajax({
                    url: "get_driver_details.php",
                    method: "POST",
                    data: { v_id: v_id },
                    dataType: 'json',
                    success: function(data) {
                        if (!data.error) {
                            $('#driver_name').val(data.driver_name);
                            $('#d_id').val(data.d_id);
                            $('#v_cost').val(data.v_cost);
                            calculateHire();
                        } else {
                            alert(data.error);
                        }
                    }
                });
            });

            function calculateHire() {
                var pickup = $('#pickup_location').val();
                var drop = $('#return_location').val();
                var v_cost = parseFloat($('#v_cost').val());

                if (pickup && drop && !isNaN(v_cost)) {
                    var service = new google.maps.DistanceMatrixService();
                    service.getDistanceMatrix(
                        {
                            origins: [pickup],
                            destinations: [drop],
                            travelMode: 'DRIVING',
                            unitSystem: google.maps.UnitSystem.METRIC,
                        }, function(response, status) {
                            if (status == 'OK') {
                                var origins = response.originAddresses;
                                var destinations = response.destinationAddresses;

                                for (var i = 0; i < origins.length; i++) {
                                    var results = response.rows[i].elements;
                                    for (var j = 0; j < results.length; j++) {
                                        var element = results[j];
                                        var distance = element.distance.value / 1000; // Convert meters to kilometers
                                        var hire = distance * v_cost;
                                        $('#distance').val(distance.toFixed(2));
                                        $('#hire').val(hire.toFixed(2));
                                    }
                                }
                            }
                        });
                }
            }

            // Call calculateHire when the pickup or drop point changes
            $('#pickup_location, #return_location').on('change', calculateHire);
        });
        </script>

        <!-- Inject SweetAlert and Google Maps API -->
        <script src="vendor/js/swal.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
        <script>
        // Initialize Google Places Autocomplete for pickup and drop inputs
        function initAutocomplete() {
            new google.maps.places.Autocomplete(document.getElementById('pickup_location'));
            new google.maps.places.Autocomplete(document.getElementById('return_location'));
        }

        // Call initAutocomplete when the page loads
        google.maps.event.addDomListener(window, 'load', initAutocomplete);
        </script>

</body>

</html>
