<?php
// include config file
require_once "config.php";

// define variables and set with empty values
$name = $address = $salary = $email = "";
$name_err = $address_err = $salary_err = $email_err = "";

$debug = "nothing yet";

// processing form data when the form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {

	$id = $_POST["id"];

	// validate name
	$input_name = trim($_POST["name"]);

	if (empty($input_name)) {
		$name_err = "Please enter a name";

	} elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP,
		array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {

		$name_err = "Please enter a valid name";	
	} else{
		$name = $input_name;
	}

	// validate address
	$input_address = trim($_POST["address"]);

	if (empty($input_address)) {
		$address_err = "Please enter an address.";
	} else{
		$address = $input_address;
	}

	//validate salary
	$input_salary = trim($_POST["salary"]);
	if (empty($input_salary)) {
	 	$salary_err = "Please enter a salary amount.";
	 } elseif (!ctype_digit($input_salary)) {
	 	$salary_err = "Please enter a positive integer value.";
	 } else{
	 	$salary = $input_salary;
	 }

	 // validate email
	 $input_email = trim($_POST["email"]);
	 if (empty($input_email)) {
	 	$email_err = "Please enter your email.";
	 } else{
	 	$email = $input_email;
	 }

	 // $debug = $input_email;
	 // check input errors before inserting into database
	 if (
	 	empty($name_err) && 
	 	empty($address_err) && 
	 	empty($salary_err) && 
	 	empty($email_err)
	 ) {

	 	# prepare an update statement
	 	$sql = "UPDATE employees SET name=?, address=?, salary=?, email=? WHERE id=?";

	 	if ($stmt = mysqli_prepare($conn, $sql)) {
	 			 
	 		// bind parameters to the prepared statement
	 		mysqli_stmt_bind_param($stmt, "ssssi", $param_name, $param_address, $param_salary, $param_email, 
	 			$param_id);

	 		// set parameters
	 		$param_name = $name;
	 		$param_address = $address;
	 		$param_salary = $salary;
	 		$param_email = $email;
	 		$param_id = $id;

	 		// attempt to execute prepared statement
	 		if (mysqli_stmt_execute($stmt)) {
	 			header("location: index.php");
	 			
	 			exit();

	 		} else{
	 			echo "Oops!Something went wrong. Please try again later!";
	 		}
	 	} else {
	 		$debug = "error";
	 	}




	 	// close stmt
	 	mysqli_close($stmt);

	 }
	 else {$debug = "asdfads";}

	 // close conn
	 // mysqli_close($conn);

} else{
	// check existence of id parameter before proceeding
	if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
		# get url parameter
		$id = trim($_GET["id"]);

		// prepare a select statement
		$sql = "SELECT * FROM employees WHERE id=?";

		if ($stmt = mysqli_prepare($conn, $sql)) {
			
			// bind parameters to the prepared stmt
			mysqli_stmt_bind_param($stmt, "i", $param_id);

			// set parameter
			$param_id = $id;

			// attempt to execute prepared statement
			if (mysqli_stmt_execute($stmt)) {
				$result = mysqli_stmt_get_result($stmt);

				if (mysqli_num_rows($result) == 1) {
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

					// retrieve individual field value
					$name = $row["name"];
					$address = $row["address"];
					$salary = $row["salary"];
					$email = $row["email"];
				} else{
					header("location : error.php");
					exit();
				}

			} else{
				echo "Oops! Something went wrong. Please try again later!";
			}
		}

		// close stmt
		mysqli_stmt_close($stmt);

		// close conn
		// mysqli_close($conn);

	} else{
		// url doesn't contain id parameter. redirect to error page
		header("location : error.php");
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Update Record</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">   
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" 
rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.7/css/mdb.min.css" 
rel="stylesheet">

<style type="text/css">
	.wrapper{
		width: 700px;
		margin: 4rem auto;
	}
	
</style>
</head>
<body>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h2>Update record</h2>
				</div>
				<p>Please edit the input values and submit to update the record.</p>

				<div class="col">
					Debug : <?php echo $debug; ?>
				</div>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
					<div class="form-group<?php echo(!empty($name_err)) ? 'has-error': '';?>">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="<?php echo $name;?>">
						<span class="help-block text-muted"><?php echo $name_err;?></span>
						
					</div>

					<div class="form-group<?php echo(!empty($address_err)) ? 'has-error': ''; ?>">
						<label>Address</label>
						<textarea name="address" class="form-control"><?php echo $address;?></textarea>
						<span class="help-block text-muted"><?php echo $address_err;?></span>
						
					</div>
					
					<div class="form-group<?php echo(!empty($salary_err)) ? 'has-error': '';?>">
						<label>Salary</label>
						<input type="text" name="salary" class="form-control" value="<?php echo $salary;?>">
						<span class="help-block text-muted"><?php echo $salary_err;?></span>
						
					</div>

					<div class="form-group<?php echo(!empty($input_email)) ? 'has-error': '';?>">
						<label>Email</label>
						<input type="text" name="email" class="form-control" value="<?php echo $email;?>">
						<span class="help-block text-muted"><?php echo $email_err;?></span>
						
					</div>

					<input type="hidden" name="id" value="<?php echo $id;?>">

					<input type="submit" class="btn btn-primary" value="submit">

					<a href="index.php" class="btn btn-default">Cancel</a>
				</form>
				
			</div>
			
		</div>
		
	</div>
	
</div>
</body>
</html>