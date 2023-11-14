<?php
// Database connection
$link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get monthly registration counts
$registrationCounts = array();
$registrationSQL = "SELECT MONTH(user_enroll_date) AS month, COUNT(*) AS count FROM uuser GROUP BY month";
$registrationResult = mysqli_query($link, $registrationSQL);
if ($registrationResult) {
    while ($row = mysqli_fetch_assoc($registrationResult)) {
        $month = $row['month'];
        $count = $row['count'];
        $registrationCounts[$month] = $count;
    }
}

// Get monthly artwork sales counts by type
$artworkSalesCounts = array();
$artworkSalesSQL = "SELECT MONTH(order_datetime) AS month, artwork_type, COUNT(*) AS count FROM oorder AS o 
                    JOIN order_artwork_detail AS OAD ON OAD.order_ID = o.order_ID
                    JOIN artwork as a ON OAD.artwork_ID= a.artwork_ID
                    GROUP BY month, artwork_type";
$artworkSalesResult = mysqli_query($link, $artworkSalesSQL);
if ($artworkSalesResult) {
    while ($row = mysqli_fetch_assoc($artworkSalesResult)) {
        $month = $row['month'];
        $type = $row['artwork_type'];
        $count = $row['count'];
        $artworkSalesCounts[$month][$type] = $count;
    }
}

// Get artist artwork collection counts
$artistCollections = array();
$artistCollectionsSQL = "SELECT u.user_name, COUNT(*) AS count FROM uuser AS u
                         JOIN collection_detail AS cd ON u.user_ID = cd.user_ID
                         JOIN artwork AS a ON cd.artwork_ID = a.artwork_ID
                         WHERE u.user_role = 'artist'
                         GROUP BY u.user_name";
$artistCollectionsResult = mysqli_query($link, $artistCollectionsSQL);
if ($artistCollectionsResult) {
    while ($row = mysqli_fetch_assoc($artistCollectionsResult)) {
        $artist = $row['user_name'];
        $count = $row['count'];
        $artistCollections[$artist] = $count;
    }
}

// Prepare data for line chart (monthly registration counts)
$months = array();
$registrationData = array();
foreach ($registrationCounts as $month => $count) {
    $months[] = date("M", mktime(0, 0, 0, $month, 1));
    $registrationData[] = $count;
}

// Prepare data for grouped bar chart (monthly artwork sales counts)
$artworkTypes = array();
$artworkSalesData = array();
foreach ($artworkSalesCounts as $month => $counts) {
    foreach ($counts as $type => $count) {
        if (!in_array($type, $artworkTypes)) {
            $artworkTypes[] = $type;
        }
        $artworkSalesData[$month][$type] = $count;
    }
}

// Sort artwork types alphabetically
sort($artworkTypes);

// Prepare data for pie chart (artist artwork collections)
$artists = array_keys($artistCollections);
$collectionCounts = array_values($artistCollections);

// Close database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Registration, Artwork Sales, and Artist Artwork Collections</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and corechart package
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        // Function to draw all charts
        function drawCharts() {
            drawRegistrationChart();
            drawArtworkSalesChart();
            drawCollectionsChart();
        }

        // Function to draw the line chart for monthly registration counts
        function drawRegistrationChart() {
            // Define the data for the line chart
            var registrationData = google.visualization.arrayToDataTable([
                ['Month', 'Registrations'],
                <?php foreach ($registrationCounts as $month => $count): ?>
                    ['<?php echo date("M", mktime(0, 0, 0, $month, 1)); ?>', <?php echo $count; ?>],
                <?php endforeach; ?>
            ]);

            // Define the options for the line chart
            var registrationOptions = {
                title: 'Monthly Registration Counts',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            // Create a new line chart and draw it
            var registrationChart = new google.visualization.LineChart(document.getElementById('registration_chart'));
            registrationChart.draw(registrationData, registrationOptions);
        }

        // Function to draw the grouped bar chart for monthly artwork sales counts
        function drawArtworkSalesChart() {
            // Define the data for the grouped bar chart
            var artworkSalesData = new google.visualization.DataTable();
            artworkSalesData.addColumn('string', 'Month');
            <?php foreach ($artworkTypes as $type): ?>
                artworkSalesData.addColumn('number', '<?php echo $type; ?>');
            <?php endforeach; ?>

            artworkSalesData.addRows([
                <?php foreach ($artworkSalesData as $month => $counts): ?>
                    ['<?php echo date("M", mktime(0, 0, 0, $month, 1)); ?>',
                     <?php foreach ($artworkTypes as $type): ?>
                        <?php echo isset($counts[$type]) ? $counts[$type] : 0; ?>,
                     <?php endforeach; ?>
                    ],
                <?php endforeach; ?>
            ]);

            // Define the options for the grouped bar chart
            var artworkSalesOptions = {
                title: 'Monthly Artwork Sales Counts by Type',
                legend: { position: 'bottom' },
                isStacked: true
            };

            // Create a new grouped bar chart and draw it
            var artworkSalesChart = new google.visualization.ColumnChart(document.getElementById('artwork_sales_chart'));
            artworkSalesChart.draw(artworkSalesData, artworkSalesOptions);
        }

        // Function to draw the pie chart for artist artwork collections
        function drawCollectionsChart() {
            // Define the data for the pie chart
            var collectionsData = google.visualization.arrayToDataTable([
                ['Artist', 'Collection Count'],
                <?php foreach ($artistCollections as $artist => $count): ?>
                    ['<?php echo $artist; ?>', <?php echo $count; ?>],
                <?php endforeach; ?>
            ]);

            // Define the options for the pie chart
            var collectionsOptions = {
                title: 'Artist Artwork Collections'
            };

            // Create a new pie chart and draw it
            var collectionsChart = new google.visualization.PieChart(document.getElementById('collections_chart'));
            collectionsChart.draw(collectionsData, collectionsOptions);
        }
    </script>
</head>
<body>
    <h1>Monthly Registration, Artwork Sales, and Artist Artwork Collections</h1>

    <h2>Monthly Registration Counts (Line Chart)</h2>
    <div id="registration_chart" style="width: 600px; height: 400px;"></div>

    <h2>Monthly Artwork Sales Counts by Type (Grouped Bar Chart)</h2>
    <div id="artwork_sales_chart" style="width: 600px; height: 400px;"></div>

    <h2>Artist Artwork Collections (Pie Chart)</h2>
    <div id="collections_chart" style="width: 600px; height: 400px;"></div>
</body>
</html>
