<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
	<link rel="stylesheet" href="profilepagestyle.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

	<?php
	include("./login/endpoints/db.php");

	$attempts = 0;
	$maxattempts = 3;
	$expireResult = "";
	$message = '';
	
	if (!isset($_COOKIE['page'])) {
		setcookie("page", "login", time() + 3600);
	}
	if (!isset($_COOKIE['attempt'])) {
		setcookie("attempt", 0, time() + 3600);
	}

	// PAGE SELECT MODULE
	if (isset($_POST["pageSelect"])) {
		if ($_POST['pageSelect'] == 'create') {
			setcookie("page", "create", time() + 3600);
		} elseif ($_POST['pageSelect'] == 'login') {
			setcookie("page", "login", time() + 3600);
		} elseif ($_POST['pageSelect'] == 'forgot') {
			setcookie("page", "forgot", time() + 3600);
		}
	}

	// ERROR MESSAGE
	if (isset($_COOKIE['attempt'])) {
		if ($_COOKIE['attempt'] < $maxattempts) {
			if($_COOKIE['attempt'] > 0){
				$message = '<div class="alert alert-danger"> Incorrect Login: (' . $_COOKIE["attempt"] . "/" . $maxattempts . ')</div>';
			}
		}
		else{
			$message = '<div class="alert alert-danger"><span id = "time"> Login Attempt Limit Reached!</span></div>';
		}
	}


	function checkUpper($array)
	{
		foreach ($array as $letter) {
			if (ctype_upper($letter)) {
				return true;
			}
		}
		return false;
	}

	function checkLower($array)
	{
		foreach ($array as $letter) {
			if (ctype_lower($letter)) {
				return true;
			}
		}
		return false;
	}

	function checkSpecial($array)
	{
		foreach ($array as $letter) {
			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $letter)) {
				return true;
			}
		}
		return false;
	}

	function checkContain($password, $string)
	{
		if (strpos(strtolower($password), strtolower($string)) !== false) {
			return true;
		} else {
			return false;
		}
	}

	function checkDictionary($password, $conn)
	{
		$sql = "SELECT word from entries";
		$list = $conn->query($sql);
		if ($list->num_rows > 0) {
			$result = $list->fetch_all(MYSQLI_ASSOC);
			foreach ($result as $row) {
				if (strlen($row['word']) >= 4) {
					if (checkContain($password, $row['word'])) {
						return $row['word'];
					}
				}
			}
			return false;
		} else {
			return false;
		}
	}
	function passwordValidation($firstname, $lastname, $password, $conn)
	{
		$result = '';
		$array = str_split($password);
		if (strlen($password) < 10) {
			$result .= "Password length must be atleast 10 characters.\n";
		}
		if (!checkUpper($array)) {
			$result .= "Password must contain atleast 1 uppercase letter.\n";
		}
		if (!checkLower($array)) {
			$result .= "Password must contain atleast 1 lowercase letter.\n";
		}
		if (!checkSpecial($array)) {
			$result .= "Password must contain atleast 1 special character.\n";
		}
		if (checkContain($password, $firstname)) {
			$result .= "Password must not be containing your first name.\n";
		}
		if (checkContain($password, $lastname)) {
			$result .= "Password must not be containing your last name.\n";
		}

		$dictionary = checkDictionary($password, $conn);
		setcookie("word", $dictionary, time() + 3600);
		if ($dictionary) {
			$result .= "Password must not contain a word from the dictionary.\n" . "$dictionary";
		}
		return $result;
	}

	function existingAccount($conn, $checkEmail)
	{
		$sql = "SELECT * FROM users WHERE email = '$checkEmail'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	function validateDate($datenow, $sqldate){
		$days = 0;
		$datenow = strtotime($datenow);
		$sqldate = strtotime($sqldate);

		$datediff = $sqldate - $datenow;

    	$days = abs(round($datediff / (60 * 60 * 24)));

		return $days;
	}

	function getDays($now, $sqldate){

		$datediff = $sqldate - $now;
		
		$days = abs(round($datediff / (60 * 60 * 24)));
		
		echo $days." days";
		
	}

	$message = '<strong>Welcome '.base64_decode($_COOKIE['user']).'</strong>';

	// RESET PASSWORD
	if (isset($_POST["resetPassword"])) {
		$email = base64_encode($_POST["forgotemail"]);
		$newpassword = $_POST["newpassword"];

		// checkPasswords($email, $conn);

		$sql = "SELECT * FROM users WHERE email = '$email'";
		$list = $conn->query($sql);
		if ($email != "" and $newpassword != "") {
			if ($list->num_rows > 0) {
				if ($_POST["g-recaptcha-response"] != '') {
					$result = $list->fetch_all(MYSQLI_ASSOC);
					foreach ($result as $row) {
						$result = passwordValidation($row["firstname"], $row["lastname"], $newpassword, $conn);
						$message = '<div class="alert alert-danger">' . $result . '</div>';
						if (strlen($result) <= 0) {
							$newpassword = base64_encode($newpassword);
							$sqlpassword = "UPDATE users SET password='$newpassword' WHERE email='$email'";
							if ($conn->query($sqlpassword) === TRUE) {
								// updateTime($row["id"], $conn);
								$message = '<strong> Account Password Successfully Updated! </strong>';
							} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
							$conn->close();
						}
					}
				} else {
					$message = '<strong> Please verify captcha. </strong>';
				}
			} else {
				$message = '<strong> Account Does Not Exist! </strong>';
			}
		} else {
			$message = '<strong> There must be no empty inputs. </strong>';
		}
	}
	?>
	<!-- Nav -->
	<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<img src="./home/All-Tasty-.png" alt="logo" width="50" height="40">
			<a class="navbar-brand" href="#">All Tasty</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto p-3 mb-2 mb-lg-0">
					<li class="nav-item ms-5">
						<a class="nav-link" href="#">Home</a>
					</li>
					<li class="nav-item ms-5">
						<a class="nav-link" href="#">Recipes</a>
					</li>
					<li class="nav-item ms-5">
						<a class="nav-link" href="#">About</a>
					</li>
					<li class="nav-item ms-5">
						<a class="nav-link" href="#">Create Recipe</a>
					</li>

				</ul>
				<button class="btn btn-dark" type="submit">Logout</button>
			</div>
		</div>
	</nav> -->
	<div class="mycontainer">
		<div class="mynavbar">
			<div class="logo">
				<img width="70px" src="./assets/All-Tasty.png" alt="">
				<h1>All Tasty</h1>
			</div>

			<div id="navigation" class="navs">
				<li><a href="./home/index.php">Home</a></li>
				<li><a href="./index.php">Recipes</a></li>
				<li><a href="./about/aboutpage.php">About</a></li>
			</div>

			<div id="loginForm" class="test">
			</div>
		</div>
	</div>
	
	<!-- End of Nav -->

	<div class="bg-profile-card">
		<div class="container">
			<!--Profile card-->
			<div class="">
				<div class="row g-0">
					<div class="col-md-3 mt-2">
						<img src="./about/merin.jpg" class="mx-auto d-block img-circle" alt="profile picture">
					</div>
					<div class="col-6">
						<div class="card-body" id = profile>

						</div>

					</div>

					<div class="pics">
						<div class="pics-group">
							<img class="rightcenter" src="./home/mushcenter.png">
							<img class="rightcenter2" src="./home/cilantro.png">
							<img class="rightcenter3" src="./home/parsley.png">
							<img class="right" src="./home/broccoliright.png">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--End of profile card-->
	<div class="container">

		<!--Posted Recipes-->
		<h3 class="">Created Recipes</h3>
		<div class="row row-cols-1 row-cols-md-4 g-4">
			<div class="col">
				<div class="card">
					<img src="./assets/blackforestcake.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>
						<p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores labore blanditiis repellat adipisci quod.</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">Last updated 3 mins ago</small>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<img src="./assets/isaw.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>
						<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, ex laborum consequuntur sunt esse repudiandae cupiditate hic! Quos, assumenda illum.</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">Last updated 3 mins ago</small>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<img src="./assets/steak.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>
						<p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi eaque quia repellendus voluptatem magnam consectetur cumque nam, ipsum voluptatum quas facilis asperiores libero consequatur? Doloremque quas fuga cum odio consectetur?</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">Last updated 3 mins ago</small>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="card">
					<img src="./assets/lettuce.png" class="card-img-top" alt="...">
					<div class="card-body">
						<h5 class="card-title">Card title</h5>
						<p class="card-text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est perspiciatis adipisci porro neque sint totam exercitationem. Esse repellat omnis perferendis laborum sapiente quisquam rerum sed ea tenetur, consequuntur dignissimos aspernatur!</p>
					</div>
					<div class="card-footer">
						<small class="text-muted">Last updated 3 mins ago</small>
					</div>
				</div>
			</div>
		</div>
		<!--End of Posted Recipes-->

		<!-- Toast -->

		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
			<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
				<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
			</symbol>
		</svg>
		<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
			<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto">New Notification</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body alert-info">
					<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
						<use xlink:href="#exclamation-triangle-fill" />
					</svg>
					<!-- <strong>Sweet potato!</strong> You have <strong> 69 days left </strong>before your password expires -->
					<?php echo $message; ?>
					<strong></strong>
				</div>
			</div>
		</div>
		<!-- End of Toast -->


		<!-- FORGOT MODULE -->
		<div class="modal fade" id="modalResetPass" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<form action="" method="POST">
						<div class="modal-header justify-content-center">
							<h5 class="brand" id="staticBackdropLabel">Forgot Password</h5>
						</div>
						<div class="modal-body">
							<div class="container">
								<h4 class="mb-3 fw-bold  text-center">Enter your new Password</h4>
								<!-- <span><?php echo $message; ?></span> -->

								<label for="forgotemail" class="form-label" style="color: red">Email Address</label>
								<div class="input-group flex-nowrap mb-3">
									<input type="email" class="form-control" placeholder="Email" id="forgotemail" name="forgotemail" value="<?php echo base64_decode($_COOKIE['email'])?>" readonly>
									<label class="input-group-text" id="addon-wrapping" for="email"><i class="fas fa-user fa-1x p-2"></i></label>
								</div>

								<label for="password" class="form-label" style="color: red">Enter New Password</label>
								<div class="input-group flex-nowrap mb-3">
									<input type="password" class="form-control" placeholder="Enter New Password" id="newpassword" name="newpassword" value="">
									<label class="input-group-text" id="addon-wrapping" for="newpassword"><i class="fas fa-lock fa-1x p-2"></i></label>
								</div>

								<div class="g-recaptcha" data-sitekey="6LeQ6qEeAAAAAHoVDImiuHU2_-kC7kkIyPrtbhtU"></div>

							</div>
						</div>

						<div class="modal-footer justify-content-between mx-3 my-2">
							<button type="submit" class="btn btn-dark" name="resetPassword">Reset</button>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
	</div>
</body>

</html>

<script>
	var toastTrigger = document.getElementById('liveToastBtn')
	var toastLiveExample = document.getElementById('liveToast')
	var toast = new bootstrap.Toast(toastLiveExample)
	toast.show()

	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for (let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	let username = atob(getCookie("user"));
	if (username != "") {
		$("#loginForm").append('<a href="./profilepage.php"> ' + username + '</a>');
		$("#loginForm").append('<a href="./index.php"><button id = "logoutBtn" class="logout">Log Out</button></a>');
		$("#navigation").append('<li><a href="form/addrecipe.php">Create Recipe</a></li>');
	} else {
		$("#loginForm").append('<a href = "./login/index.php">Log In</a>');
		// $("#loginForm").append('<a href = "./login/index.php"><button class="signup">Sign Up →</button></a>');
	}
	$("#logoutBtn").click(function() {
		if (username != "") {
			document.cookie = `id= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
            document.cookie = `user= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
            document.cookie = `email= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
			location.reload();
		}
	});
	
	function loadProfile(id){
        $.ajax({
        url: "./loadprofile.php",
        type: "POST",
        data:{
            "id": (id),
        },
        success: function(response){
			var firstname = atob(response[0].firstname);
			var lastname = atob(response[0].lastname);
			var email = atob(response[0].email);
			// document.cookie = "email="+response[0].email;
			
			// $("#profile").append('<h1>'+recipe.recipe_name+'</h1> <p>'+recipe.recipe_description+'</p> <div class="time-grid">  <div id = "recipeServings" class="time-square-1"> <div class="time-title-1">Serving</div> <div class="time-alotted">'+recipe.servings+' servings</div></div><div id = "recipeTime" class="time-square-2"><div class="time-title-2">Cook</div><div class="time-alotted">'+cooktime+'</div></div></div>')
            // <p class="profile-name"> </p>
			$("#profile").append('<p class="profile-name">'+firstname+' '+lastname+'</p>');
			$("#profile").append('<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In nihil beatae aspernatur ipsam quam debitis? </p>');
			$("#profile").append('<p class="profile-info">'+email+'</p>');
			$("#profile").append('<a class="mylink" data-bs-toggle="modal" data-bs-target="#modalResetPass"> Reset Password </a>');
			}
        });
    }
	
	loadProfile(getCookie('id'));
</script>