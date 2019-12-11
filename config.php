<?php
// connection variables
$host = "localhost";
$user = "root";
$password = "";
$database = "demo";



// create connection
$conn = mysqli_connect($host, $user, $password, $database);

// check connection
if (!$conn) {
	die ("Connection failed: " .mysqli_connect_error());
}
// echo "Connection successful!";


// create db
// $sql = "CREATE DATABASE demo";
// if (mysqli_query($conn, $sql)) {
// 	echo "Database created successfully!";
// }
// else{
// 	echo "Error creating database!".mysqli_error($conn);
// }

// create table
// $sql = "CREATE TABLE employees(
// id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// name VARCHAR(20) NOT NULL,
// address VARCHAR(20) NOT NULL,
// salary INT(10) NOT NULL,
// email VARCHAR(20) NOT NULL,
// reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";

// if (mysqli_query($conn,$sql)) {
// 	echo "Table created successfully!";
// } else{
// 	echo "Error creating table!".mysqli_error($conn);
// }

// insert values 
// $sql = "INSERT INTO employees(name, address, salary, email) VALUES 
// 	('Maureen Njeri','30025','500000','njeri@mail.com'),
// 	('John Doe', '10235', '410000','john.doe@mail.com'),
// 	('Mary Jane','20032', '329453','janemary@mail.com')";

// if (mysqli_query($conn,$sql)) {
// 	echo "Records added successfully!";
// } else{
// 	echo "Error executing $sql. " .mysqli_error($conn);
// }


// close connection
// mysqli_close($conn);
?>