<?php
// connect to the database
$link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
if (!$link) {
    die('Failed to connect to the database.');
}

// retrieve artist ID from the request
$artistID = $_GET['artist_id'];

// retrieve artworks based on the artist ID
$query = "SELECT * FROM artwork WHERE user_ID = '$artistID' AND artwork_price IS NULL";
$result = mysqli_query($link, $query);

// create an array to store the artworks
$artworks = array();

// loop through the query results and add artworks to the array
while ($row = mysqli_fetch_assoc($result)) {
    $artwork = array(
        'artwork_ID' => $row['artwork_ID'],
        'artwork_name' => $row['artwork_name']
    );
    $artworks[] = $artwork;
}

// return the artworks as JSON
echo json_encode($artworks);

mysqli_close($link);
?>
