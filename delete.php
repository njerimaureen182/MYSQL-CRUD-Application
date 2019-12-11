<?php
// deletes record from existing table based on the id of the employee

// include config file
require_once 'config.php';
	
if (isset($_POST["id"]) && !empty($_POST["id"])) {

	

	// prepare delete statement
	$sql = "DELETE FROM employees WHERE id = ?";

	if ($stmt = mysqli_prepare($conn, $sql)) {

		// bind parameter to the statement
		mysqli_stmt_bind_param($stmt, "i", $param_id);

		// set parameter
		$param_id = trim($_POST["id"]);

		// attempt to execute statement
		if (mysqli_stmt_execute($stmt)) {

			header("location: index.php");

			exit();
		} else{
			echo "Oops!Something went wrong. Please try again later.";
		}

	}

	// close statement
	mysqli_stmt_close($stmt);

	// close conn
	// mysqli_close($conn);

} else {
	// check existence of id parameter
	if (empty(trim($_GET["id"]))) {

		header("location : error.php");

		exit();
	}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Delete record</title>
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
					<h2>Delete record</h2>
				</div>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="alert alert-danger fade-in">
						<input type="hidden" name="id" value="<?php echo trim($_GET["id"]);?>"/>
						<p>Are you sure you want to delete this record</p><br>
						<p>
							<input type="submit" value="Yes" class="btn btn-danger">
							<a href="index.php" class="btn btn-default">No</a>
						</p>
						
					</div>
					
				</form>
				
			</div>
			
		</div>
		
	</div>
	
</div>
</body>
</html>