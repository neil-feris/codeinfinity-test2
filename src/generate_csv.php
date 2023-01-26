<?php
// ini_set('max_execution_time', 300); //300 seconds = 5 minutes
session_start();

if (isset($_POST['num_variations'])) {
    // Get number of rows from form
    $numRows = $_POST['num_variations'];

    // Generate CSV file
    generateCSV($numRows);
    $_SESSION['message'] = "CSV file generated with " . $numRows . " variations.";
    header("Location: index.php");
    exit();
} else {
    // redirect to index.php if no number of rows is specified
    header("Location: index.php");
}


// Function to generate a CSV file
function generateCSV($numRows)
{
    // Create arrays of names and surnames
    $names = array("John", "Jack", "Neil", "Samantha", "Emily", "Michael", "Andries", "Jaco", "Amanda", "Matt", "Peter", "Joshua", "Sarah", "Nicholas", "Alyssa", "Andrew", "Toby", "David", "Megan", "Fanie");

    $surnames = array("Smith", "Abrahams", "Williams", "Jones", "Brown", "Jaquire", "Miller", "Wilson", "Laubscher", "Taylor", "Anderson", "Thomas", "Jackson", "White", "Harris", "Martin", "Thompson", "Van de Merwe", "de Villiers", "Mandela");

    // Check if the output folder exists, if not create it
    if (!file_exists("output")) {
        mkdir("output");
    }
    // Open file for writing in output folder and with a specific name "output.csv"
    $file = fopen("output/output.csv", "w");

    // Write header row
    fputcsv($file, array("Id", "Name", "Surname", "Initials", "Age", "DateOfBirth"));

    // Create an array to store used data
    $usedData = array();


    // // time how long the loop takes to run
    // $start = microtime(true);

    // Loop to generate specified number of rows
    for ($i = 1; $i <= $numRows; $i++) {
        // Randomly select a name and surname
        $name = $names[array_rand($names)];
        $surname = $surnames[array_rand($surnames)];

        // Initials is the first letter of the name
        $initials = substr($name, 0, 1);
        // Randomly select an age between 18 and 60
        $age = mt_rand(18, 60);
        // Randomly select month and day
        $month = mt_rand(1, 12);
        $day = mt_rand(1, 28);
        $dateOfBirth = date("Y-m-d", strtotime("-" . $age . " years -" . $month . " month -" . $day . " day"));

        //create a key to check for the data in the hash table
        $key = "$name$surname$initials$age$dateOfBirth";
        //check if the data already exists
        if (array_key_exists($key, $usedData)) {
            $i--;
            continue;
        }
        //add the current data to usedData array
        $usedData[$key] = true;

        // Write data row
        fputcsv($file, array($i, $name, $surname, $initials, $age, $dateOfBirth));
    }

    // // Print time taken to generate file rounded to 4 decimal places
    // echo "Time taken: " . round(microtime(true) - $start, 4) . " seconds\n";




    // Close file
    fclose($file);
}
?>