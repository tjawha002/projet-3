<?php 
	session_start();
	
	include "db_connection.php";

	$email = "";
	$name = "";
	$profile = "";
	$adminPage = "";
	$logout = "";

	if(isset($_SESSION['username'])){
		$email = $_SESSION['username'];
		$name = substr($_SESSION['fname'], 0, 1) . substr($_SESSION['lname'], 0, 1);
		$name = "<div class='login-icon'>$name</div>";
		$profile = "<a href='profile.php?email=$email'>Profile</a>";
		//$adminPage = "<a href='admin_board.php'>Add New Restaurant</a>";
		$logout = "<a href='logout.php' class='text-danger'>Logout</a>";
	}
	else{
		header('Location: index.php');
	}

	$msg = "";

	//Check User Info Query
	$sql = mysqli_query($db,"Select * from users where email = '$email' ");
	$row = mysqli_fetch_array($sql);

	$fname = $row['fname'];
	$lname = $row['lname'];
	$ans1 = $row['q1'];
	$ans2 = $row['q2'];

	if(isset($_POST['editProfile'])){
		$fN = $_POST['fname'];
		$lN = $_POST['lname'];
		$q1 = $_POST['ans1'];
		$q2 = $_POST['ans2'];
		$email = $_POST['userEmail'];

		$sql2 = mysqli_query($db,"Update users set fname = '$fN', lname = '$lN', q1 = '$ans1', q2 = '$ans2' where email = '$email' ");
		if($sql2){
			$msg = "Your profile has been updated successfully";
		}
		else{
			$msg = "Error: could not update your profile";
		}

	}

	//Change Password
	if(isset($_POST['changePass'])){
		$old_password = $_POST['oldPass'];
		$new_password = $_POST['newPass'];
		$email = $_POST['passEmail'];

		//First step: check if the old password match the password in the Database
		$sqlCheck = $sql = mysqli_query($db,"Select password from users where email = '$email' ");
		$row2 = mysqli_fetch_array($sqlCheck);
		$db_pass = $row2['password'];
		if(password_verify($old_password,$db_pass)){
			$new_password = password_hash($new_password, PASSWORD_DEFAULT);
			$sql3 = mysqli_query($db,"Update users set password = '$new_password' where email = '$email' ");
			if($sql3){
				$msg = "Your password has been changed successfully";
			}
			else{
				$msg = "Error: could not change your password";
			}
		}
		else{
			$msg = "Error: your old password does not match the saved password";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<style type="text/css">
		.login-icon {
			background-color: #0275d8;
			color: white;
			font-weight: bold;
			font-size: 20px;
			padding: 5px;
			text-align: center;
			border-radius: 20px;

		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav">
			  <li class="nav-item active">
				<a class="nav-link" href="index.php">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="profile.php">Profile</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="search.php">Search</a>
			  </li>
			</ul>
		  </div>
		</nav>
		
	<div class="container py-5">
		<div class="row">
			<div class="col-lg-9">
				<div class="col-12 mx-auto">
					<div class="card">
						<div class="card-header">
							<a href="index.php"> << Back </a>
							<h5>Saved Items <small class="text-muted">from previous searches</small></h5>
						</div>
						<div class="card-body">
							<div class="row">
								<?php 
									// get save items
									$sql = mysqli_query($db,"Select * from saves where user_email = '$email' ");
									

									while ($item = mysqli_fetch_array($sql)) {
										$i['_source'] = unserialize($item['value']);
									// var_dump($i);
										$x=0;
										include('inc/image.php');
									}
								?>
							</div>
							
						</div>
					</div>

				</div>
			</div>
			<div class="col-lg-3">
				<div class="row">
					<div class="col-lg-3">
						<?php echo $name; ?>
					</div>
					<div class="col-lg-9">
						<p><?php echo $profile; ?></p>
						<p><?php echo $adminPage; ?></p>
						<p><?php echo $logout; ?></p>
					</div>
				</div>
				<div class="card">
					<h5 class="card-header">
						<?php echo $fname ." ". $lname ." Profile"; ?>
							
					</h5>
					<div class="card-body">
						<div align="center"><?php echo $msg; ?></div>
						<!-- Change Profile -->
						<form action="" method="post">
							<input type="hidden" name="userEmail" value="<?php echo $email; ?>">
							<label>First Name:</label>
							<input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control" required>
							<label>Last Name:</label>
							<input type="text" name="lname" value="<?php echo $lname; ?>" class="form-control" required>
							<label>What is your best friend's name?</label>
							<input type="text" name="ans1" value="<?php echo $ans1; ?>" class="form-control" required>
							<label>What is the name of the city you was born?</label>
							<input type="text" name="ans2" value="<?php echo $ans2; ?>" class="form-control" required><br>
							<p>
								<button type="submit" name="editProfile" class="btn btn-warning">Edit Profile</button>
							</p>
						</form>
						<p>
							<a class="btn btn-danger" data-toggle="collapse" href="#password" role="button" aria-expanded="false" aria-controls="password">Change Password</a>
							<div class="collapse" id="password">
								<!-- Change Password -->
								<form action="" method="post">
									<input type="hidden" name="passEmail" value="<?php echo $email; ?>">
									<div class="row">
										<div class="col-lg-6">
											<input type="password" name="oldPass" class="form-control" placeholder="Enter your old password" required>
										</div>
										<div class="col-lg-6">
											<input type="password" name="newPass" class="form-control" placeholder="Enter your new password" required>
										</div>
										<div class="col-12 py-2">
											<button class="btn btn-warning" type="submit" name="changePass">Change</button>
										</div>
									</div>
								</form>
							</div>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include('inc/item-modal.php') ?>
	
<script type="text/javascript">
$(function() {
	var $body = $('body')


	$body.on('click', '.show-desc', function(e) {
		e.preventDefault();
		console.log('Modal', this, e)
		var $modal = $('#desc-modal').modal()
			$this = $(this)


		console.log($this.data('aspect'))

		var html = '<img src="'+$this.data('image')+'" height="200" >'+
					'<p class="text-muted">'+$this.data('origreftext')+'</p>'+
					'<p class="">'+$this.data('dd')+'</p>'

		$modal.find('.modal-title').html($this.data('aspect'))
		$modal.find('.modal-body').html(html)

		$modal.modal('show')
	})


	$body.on('click', 'button.save', function(e) {
		var $this = $(this),
			url = "ajax/save.php",
			data = {
				value: $this.data('source'),
				user_email: $this.data('user_email')
			}

		$this.prop('disabled', true)
		var jqxhr = $.post( url, data)
		.done(function(res) {
			console.log(res)
			alert( res );
		})
		.fail(function() {
			alert( "error" );
		})
		.always(function() {
			$this.prop('disabled', false)
			// alert( "finished" );
		});

	})
})
</script>
</body>
</html>