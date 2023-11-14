<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
    // Check if exhibition_ID is provided
    if (isset($_GET['exhibition_ID'])) {
        $exhibitionID = $_GET['exhibition_ID'];

        // Connect to the database
        $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
        if (!$link) {
            die('Failed to connect to the database.');
        }

        $updateArtworkQuery = "UPDATE artwork SET exhibition_ID = NULL WHERE exhibition_ID = '$exhibitionID'";
        $updateArtworkResult = mysqli_query($link, $updateArtworkQuery);
        // Delete the exhibition from the database
        $deleteTicketQuery = "DELETE FROM ticket WHERE exhibition_ID = '$exhibitionID'";
        $deleteTicketResult = mysqli_query($link, $deleteTicketQuery);
        $deleteExhibitionQuery = "DELETE FROM exhibition WHERE exhibition_ID = '$exhibitionID'";
        $deleteExhibitionResult = mysqli_query($link, $deleteExhibitionQuery);


        if ($deleteExhibitionResult) {
            echo "展覽及相關作品已成功刪除。";
            sleep(2);
            header("Location: manage_exhibition.php");
            exit;
        } else {
            echo "刪除展覽時發生錯誤。";
        }

        mysqli_close($link);
    } else {
        echo "缺少展覽ID。";
    }
} else {
    echo "您沒有權限訪問此頁面。";
}
