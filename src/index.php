<!DOCTYPE html>
<html>

<head>
    <title>CSV Generator and Importer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php
    // start session
    session_start();
    // ini_set('upload_max_filesize', '50M');
    // ini_set('post_max_size', '50M');
    ?>
    <h1>CSV Generator</h1>
    <form action="generate_csv.php" method="post">
        <label for="num_variations">Number of entries:</label>
        <input type="number" id="num_variations" name="num_variations" min="1" required>
        <input type="submit" value="Generate CSV">
    </form>


    <h1>CSV Importer</h1>
    <form action="import_csv.php" method="post" enctype="multipart/form-data">
        <label for="file">Select CSV file to import:</label>
        <input type="file" id="file" name="csv" accept=".csv" required>
        <input type="submit" value="Import CSV">
    </form>
    <?php
    // check if there is a message to display
    if (isset($_SESSION['message'])) {
        echo "<div class='status'> <p>" . $_SESSION['message'] . "</p> </div>";
        unset($_SESSION['message']);
    } ?>
</body>

</html>