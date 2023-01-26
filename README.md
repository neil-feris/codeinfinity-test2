# Installation

- Clone the repository: git clone https://github.com/neil-feris/codeinfinity-test2
- Change into the project directory
- Install dependencies: composer install

# Running the Project

- cd into the src directory
- Start the development server: php -S localhost:8000
- Navigate to http://localhost:8000 in your browser
- Use the form on the page to generate a CSV file with a specified number of variations. It will be in the src/output directory.
- the file will be named output.csv
- the page will display the number of records generated and any errors that occurred.

- Use the form on the page to import a CSV file and insert the records into the sqlite database
- The page will display the number of records imported.

## Note

- The file size and post limit of the server should be set to ~50MB. The vsc with 1 Million records is ~40MB.
- This can be done by adding the following line to the php.ini file: upload_max_filesize = 50M and post_max_size = 50M

- Ensure that the php_pdo_sqlite extension is enabled on your server.
