<?php
require_once 'config.php';

// define variables and initialize/set to empty values:
$name = $address = $salary = $email = "";
$name_err = $address_err = $salary_err = $email_err = "";

// to process form data when the form is submitted:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// validate name
	$input_name = trim($_POST["name"]);

	if (empty($input_name)) {
		$name_err = "Please enter your name.";

	} elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, 
		array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {

		$name_err = "Please enter a valid name.";
	} else {

		$name = $input_name;
	}

	// validate address
	$input_address = trim($_POST["address"]);
	if (empty($input_address)) {
		$address_err = "Please enter your address.";
	} else{
		$address = $input_address;
	}

	// validate salary
	$input_salary = trim($_POST["salary"]);
	if (empty($input_salary)) {
		$salary_err = "Please enter your salary.";
	} elseif (!ctype_digit($input_salary)) {
		$salary_err = "Please enter a positive integer value.";
	} else{
		$salary = $input_salary;
	}

	// validate email
	$input_email = trim($_POST["email"]);
	if (empty($input_email)) {
		$email_err = "please enter your email";
	} else{
		$email = $input_email;
	}


	// check input errors before inserting into database
	if (empty($name_err) && empty($address_err) && empty($salary_err) && empty($email_err)) {
		
		// prepare insert statement
		$sql = "INSERT INTO employees(name, address, salary, email) VALUES(?, ?, ?, ?)";

		// prepare sql statement
		if ($stmt = mysqli_prepare($conn, $sql)) {

			//bind parameters to the prepared statement
			mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_address, $param_salary, $param_email); 

			// set parameters
			$param_name = $name;
			$param_address = $address;
			$param_salary = $salary;
			$param_email = $email;

			// attempt to execute the statement
			if (mysqli_stmt_execute($stmt)) {

				// record created successfully. return to landing page
				header("location:index.php");

				exit();

			} else{

				echo "Something went wrong. Please try again later.";

			}
		}

		// close statement
		mysqli_stmt_close($stmt);

	}

	// close connection
	// mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Create record</title>
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
					<h2>Create employee record</h2>
				</div>
				<p>Please fill this form and submit to add employee record to the database.</p>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

					<!-- name -->
					<div class="form-group<?php echo(!empty($name_err)) ? 'has-error': '';?>">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="<?php echo $name;?>">
						<span class="help-block text-muted"><?php echo $name_err; ?></span>
					</div>

					<!-- address -->
					<div class="form-group<?php echo(!empty($address_err)) ? 'has-error': '';?>">
						<label>Address</label>
						<textarea name="address" class="form-control"><?php echo $address; ?></textarea>
						<span class="help-block text-muted"><?php echo $address_err;?></span>
					</div>

					<!-- salary -->
					<div class="form-group<?php echo(!empty($salary_err)) ? 'has-error': '';?>">
						<label>Salary</label>
						<input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
						<span class="help-block text-muted"><?php echo $salary_err;?></span>
					</div>

					<!-- email -->
					<div class="form-group<?php echo(!empty($email_err)) ? 'has-error': '';?>">
						<label>Email</label>
						<input type="text" name="email" class="form-control" value="<?php echo $email;?>">
						<span class="help-block text-muted"><?php echo $email_err;?></span>
					</div>

					<!-- submit -->
					<input type="submit" value="submit" class="btn btn-primary">
					<a href="index.php" class="btn btn-default">Cancel</a>
					
				</form>
				
			</div>
			
		</div>
		
	</div>
	
</div>

</body>
</html>
