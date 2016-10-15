<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DCIMStack</title>
    <?php
    if (!ctype_digit($_GET['device_id'])) {
        header('Location: index.php');
        exit();
    } else {
        include 'libraries/css.php';
        include 'libraries/general.php';
        include 'config/db.php';
        $device_id = mysqli_real_escape_string($conn, $_GET['device_id']);
        $_SESSION['referrer'] = "manage_disk.php?device_id=$device_id"; //manually set it here.       
        $sql = "SELECT * FROM `devices` WHERE `device_id`='$device_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $device_label    = $row["device_label"];
                $device_brand    = $row["device_brand"];
                $device_type     = $row["device_type"];
                $device_serial   = $row["device_serial"];
                $device_capacity = $row["device_capacity"];
                $device_inuse    = $row["device_inuse"];
                $device_parent   = $row["device_parent"];
                $device_rack     = $row["rackid"];
            }
        }
    }
    ?>
</head>

<body>
    <?php include 'libraries/header.php'; ?>
    
    <div class="container">
        <h1 class="page-header"><?php echo $device_label; ?></h1>
        <ol class="breadcrumb">
            <li><a href="manage_rackspace.php"><?php echo get_rack_location($device_rack); ?></a></li>
            <li><a href="rackspace.php?rackid=<?php echo $device_rack; ?>"><?php echo get_rack_name_from_device_id($device_id); ?></a></li>
            <li class="active"><?php echo $device_label; ?></li>
        </ol>
        <?php include 'libraries/alerts.php'; ?>
        <div id="content">
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#server" data-toggle="tab"><img src="assets/img/calculator.png"> Server</a></li>
                <li><a href="#rack" data-toggle="tab"><img src="assets/img/drive.png"> Rack</a></li>
                <li><a href="#capacity" data-toggle="tab"><img src="assets/img/drive.png"> Capacity</a></li>
                <li><a href="#delete_device" data-toggle="tab"><img src="assets/img/delete.png"> Delete Device</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="server">
                    <?php include 'tab_server.php'; ?>
                </div>
                <div class="tab-pane" id="rack">
                    <?php include 'tab_rack.php'; ?>
                </div>
                <div class="tab-pane" id="capacity">
                    <?php include 'tab_capacity.php'; ?>
                </div>
                <div class="tab-pane" id="delete_device">
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <b>Warning</b>
                        <br>
                        Once this device is deleted/removed it cannot be restored back into DCIMStack, any associated data is deleted once the device is removed from DCIMStack. The device & it's associated information will need to be re-added manually later if needed.
                    </div>
                    <a href="delete_device.php?device_id=<?php echo $device_id; ?>" class="btn btn-danger confirmation">Remove Device</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include 'libraries/js.php'; ?>
</body>
</html>