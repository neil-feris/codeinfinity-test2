<?php

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;

use League\Csv\Reader;

// Connect to the database
$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => 'db.sqlite',
]);


session_start();
if ($_FILES['csv']['error'] > 0) {
    $_SESSION['message'] = "Error: " . $_FILES['csv']['error'];
    header("Location: index.php");
    exit();
}

// Check if the form was submitted
if (!empty($_FILES['csv']['tmp_name'])) {
    $csv = Reader::createFromPath($_FILES['csv']['tmp_name']);
    // echo "CSV file uploaded successfully.";
    $csv->setHeaderOffset(0); //set the CSV header offset
    $records = $csv->getRecords();
    $count = 0;

    // drop table if exists
    if ($connection->createSchemaManager()->tablesExist(['csv_import'])) {
        // echo "Table already exists. Dropping table...";
        $connection->executeQuery('DROP TABLE csv_import');
    }

    $schema = new Schema();
    if ($connection->createSchemaManager()->tablesExist(['csv_import'])) {
        // echo "Table already exists. Dropping table...";
        $connection->executeQuery('DROP TABLE csv_import');
    }

    $table = $schema->createTable("csv_import");
    $table->addColumn("id", "integer", array("unsigned" => true, "autoincrement" => true));
    $table->addColumn("name", "string", array("length" => 32));
    $table->addColumn("surname", "string", array("length" => 32));
    $table->addColumn("initials", "string", array("length" => 4));
    $table->addColumn("age", "integer", array("unsigned" => true));
    $table->addColumn("dateofbirth", "string", array("length" => 32));
    $table->setPrimaryKey(array("id"));

    $queries = $schema->toSql($connection->getDatabasePlatform());
    foreach ($queries as $query) {
        $connection->executeQuery($query);
    }

    echo "Table created successfully.";

    foreach ($records as $record) {
        // print_r($record);
        $connection->insert('csv_import', $record);
        $count++;
    }
    // set message
    $_SESSION['message'] = $count . " records imported successfully.";
    header("Location: index.php");
    exit();
} else {
    $_SESSION['message'] = "No file uploaded.";
    header("Location: index.php");
    exit();
}