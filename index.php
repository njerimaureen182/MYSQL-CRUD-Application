<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Employees</title>
<!-- Style Sheets -->
<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">   
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" 
rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.7/css/mdb.min.css" 
rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- script tags -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<style type="text/css">
	.wrapper {
	width: 800px;
	margin: 0 auto;
}

.page-header h2 {
	margin-top: 3rem;
}

table tr td:last-child a{
	margin-right: 15px;
}
</style>

<script type="text/javascript">
	$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>

</head>

<body>

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-header clearfix">
					<h2 class="pull-left">Employee Details</h2>
					<br>
					<a href="create.php" class="btn btn-info pull-right">Add new employee</a>
					<br><br>
				</div>

				<!-- add config file -->
				<?php
				require_once "config.php";

				// execute select query 
				$sql = "SELECT * FROM employees";
				if ($result = mysqli_query($conn, $sql)) {
					if (mysqli_num_rows($result)>0) {
						echo "<table class = 'table table-bordered table-striped'>";
							echo "<thead>";
								echo "<tr>";
									echo "<th>#</th>";
									echo "<th>Name</th>";
									echo "<th>Address</th>";
									echo "<th>Salary</th>";
									echo "<th>Email</th>";
									echo "<th>Action</th>";
								echo "</tr>";
							echo "</thead>";

							echo "<tbody>";
							while ($row = mysqli_fetch_array($result)) {
								echo "<tr>";
									echo "<td>".$row['id']."</td>";
									echo "<td>".$row['name']."</td>";
									echo "<td>".$row['address']."</td>";
									echo "<td>".$row['salary']."</td>";
									echo "<td>".$row['email']."</td>";

									echo "<td>";

										echo "<a href ='read.php?id=".$row['id']."' title='View Record' data-toggle='tooltip'><i class='fas fa-eye'></i></a>";
										echo "<a href='update.php?id=".$row['id']."' title='Update Record' data-toggle='tooltip'><i class='fas fa-pen'></i></a>";
										echo "<a href ='delete.php?id=".$row['id']."' title = 'Delete Record' data-toggle='tooltip'><i class='fas fa-trash-alt'></i></a>";

									echo "</td>";

								echo "</tr>";

							}
							echo "</tbody>";

						echo "</table>";

						// free result set
						mysqli_free_result($result);
					} else{
						echo "<p class='lead'><em>No record found</em></p>";
					}
				} else{
					echo "Error: Could not execute $sql. " . mysqli_error($conn);
				}

				// close connection
				// mysqli_close($conn);
				?>
				
			</div>
			
		</div>
		
	</div>
	
</div>

</body>
</html>