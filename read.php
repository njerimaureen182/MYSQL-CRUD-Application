<?php
// to check existence of the id parameter
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
	
	// include config file
	require_once 'config.php';

	// prepare select statement
	$sql = "SELECT * FROM employees WHERE id = ?";

	if ($stmt = mysqli_prepare($conn, $sql)) {

		// bind parameters to the prepared statement
		mysqli_stmt_bind_param($stmt, "i", $param_id);

		// set parameter
		$param_id = trim($_GET["id"]);

		// attempt to execute the prepared statement
		if (mysqli_stmt_execute($stmt)) {
			
			$result = mysqli_stmt_get_result($stmt);

			if (mysqli_num_rows($result) == 1) {

				// Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop 
				
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

				// retrieve individual field values
				$name = $row["name"];
				$address = $row["address"];
				$salary = $row["salary"];
				$email = $row["email"];

			} else{
				header("location : error.php");
				exit();
			}
		} else{
			echo "Something went wrong. Please try again later!";
		}
	}

	// close statement
	mysqli_stmt_close($stmt);

	// close connection
	// mysqli_close($conn);

} else{
	header("location : error.php");
	exit();
}
?>