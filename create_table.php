<?php
require 'vendor/autoload.php';
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;

$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => 'db.sqlite',
]);

$schema = new Schema();
if ($connection->createSchemaManager()->tablesExist(['csv_import'])) {
    echo "Table already exists. Dropping table...";
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