<?php
session_start();
include('vendor/inc/config.php');
include('vendor/inc/checklogin.php');
check_login();
$aid = $_SESSION['u_id'];

// Add Booking
if (isset($_POST['book_vehicle'])) {
    $u_id = $_SESSION['u_id'];
    $v_id = $_GET['v_id'];
    $b_date = $_POST['b_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $distance = $_POST['distance'];
    $hire = $_POST['hire'];
    $b_status = 'Pending';

    // Validate all required fields
    if (empty($u_id) || empty($v_id) || empty($b_date) || empty($pickup_location) || 
        empty($return_location) || empty($distance) || empty($hire)) {
        $err = "All fields are required. Please ensure you've calculated the hire before booking.";
    } else {
        // Convert distance and hire to float to ensure they're not null
        $distance = floatval($distance);
        $hire = floatval($hire);

        // Insert the booking into tms_bookings
        $query = "INSERT INTO tms_bookings (u_id, v_id, b_date, pickup_location, return_location, distance, hire, b_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iissssds', $u_id, $v_id, $b_date, $pickup_location, $return_location, $distance, $hire, $b_status);
        
        if ($stmt->execute()) {
            $succ = "Booking Submitted Successfully";
        } else {
            $err = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

function getDriverName($mysqli, $d_id) {
    $query = "SELECT d_fname, d_lname FROM tms_driver WHERE d_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $d_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $driver = $result->fetch_assoc();
    $stmt->close();
    
    if ($driver) {
        return $driver['d_fname'] . ' ' . $driver['d_lname'];
    } else {
        return 'Driver Not Found';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include('vendor/inc/head.php'); ?>

<body id="page-top">
    <?php include("vendor/inc/nav.php"); ?>

    <div id="wrapper">
        <?php include('vendor/inc/sidebar.php'); ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($succ)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Success!", "<?php echo $succ; ?>", "success");
                        }, 100);
                    </script>
                <?php } ?>
                <?php if (isset($err)) { ?>
                    <script>
                        setTimeout(function() {
                            swal("Failed!", "<?php echo $err; ?>", "error");
                        }, 100);
                    </script>
                <?php } ?>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="user-dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item">Book Vehicle</li>
                    <li class="breadcrumb-item active">Confirm Booking</li>
                </ol>

                <div class="card">
                    <div class="card-header">Confirm Booking</div>
                    <div class="card-body">
                        <?php
                        $aid = $_GET['v_id'];
                        $ret = "SELECT * FROM tms_vehicle WHERE v_id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                            $driver_name = getDriverName($mysqli, $row->d_id);
                        ?>
                            <form method="POST">
                                <div class="form-group">
                                    <label>Vehicle Name</label>
                                    <input type="text" value="<?php echo $row->v_name; ?>" readonly class="form-control" name="v_name">
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Registration Number</label>
                                    <input type="text" value="<?php echo $row->v_reg_no; ?>" readonly class="form-control" name="v_reg_no">
                                </div>
                                <div class="form-group">
                                    <label>Driver Name</label>
                                    <input type="text" value="<?php echo $driver_name; ?>" readonly class="form-control" name="driver_name">
                                </div>
                                <div class="form-group">
                                    <label>Booking Date</label>
                                    <input type="date" class="form-control" name="b_date" required>
                                </div>
                                <div class="form-group">
                                    <label>Pickup Point</label>
                                    <input type="text" class="form-control" id="pickup_location" name="pickup_location" required>
                                </div>
                                <div class="form-group">
                                    <label>Drop Point</label>
                                    <input type="text" class="form-control" id="return_location" name="return_location" required>
                                </div>
                                <div class="form-group">
                                    <label>Total Distance (km)</label>
                                    <input type="text" class="form-control" id="distance" name="distance" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Total Hire</label>
                                    <input type="text" class="form-control" id="hire" name="hire" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Price per km</label>
                                    <input type="text" value="<?php echo $row->v_cost; ?>" readonly class="form-control" id="v_cost" name="v_cost">
                                </div>
                                <button type="submit" name="book_vehicle" class="btn btn-success">Confirm Booking</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php include("vendor/inc/footer.php"); ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php include("vendor/inc/logout.php"); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/js/sb-admin.min.js"></script>
    <script src="vendor/js/swal.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz6zabR9k2B9hba52HNoHciRVW4B3gGbk&libraries=places"></script>
    <script>
    function calculateHire() {
        var pickup = document.getElementById('pickup_location').value;
        var drop = document.getElementById('return_location').value;
        var v_cost = parseFloat(document.getElementById('v_cost').value);

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
                                document.getElementById('distance').value = distance.toFixed(2);
                                document.getElementById('hire').value = hire.toFixed(2);
                            }
                        }
                    } else {
                        console.error("Unable to calculate distance. Please check the addresses and try again.");
                        document.getElementById('distance').value = "";
                        document.getElementById('hire').value = "";
                    }
                });
        } else {
            document.getElementById('distance').value = "";
            document.getElementById('hire').value = "";
        }
    }

    // Initialize Google Places Autocomplete for pickup and drop inputs
    function initAutocomplete() {
        var pickupInput = document.getElementById('pickup_location');
        var returnInput = document.getElementById('return_location');

        new google.maps.places.Autocomplete(pickupInput);
        new google.maps.places.Autocomplete(returnInput);

        // Add event listeners to recalculate when the input changes
        pickupInput.addEventListener('change', calculateHire);
        returnInput.addEventListener('change', calculateHire);
    }

    // Call initAutocomplete when the page loads
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>

</body>
</html>
