<?php
    // Start the session
    session_start();

    // Check if the user is logged in as admin
    if(isset($_SESSION['username']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'artist')) {
        // Check if the artwork ID is provided
        if(isset($_GET['artwork_id'])) {
            // Get the artwork ID from the URL parameter
            $artworkID = $_GET['artwork_id'];

            // Connect to the database
            $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
            if(!$link) {
                die('Failed to connect to the database.');
            }

            // Update the artwork type to '下架'
            $query = "UPDATE artwork SET artwork_type = '下架' WHERE artwork_ID = '$artworkID'";
            $result = mysqli_query($link, $query);

            if($result) {
                // Redirect back to the inventory management page
                header('Location: manage_inventory.php');
                exit();
            } else {
                echo "Failed to update the artwork type.";
            }

            mysqli_close($link);
        } else {
            echo "Invalid artwork ID.";
        }
    } else {
        echo "您沒有權限訪問此頁面。";
    }
?>
