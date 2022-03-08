<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tasty Profile</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
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
			if ($_COOKIE['attempt'] > 0) {
				$message = '<div class="alert alert-danger"> Incorrect Login: (' . $_COOKIE["attempt"] . "/" . $maxattempts . ')</div>';
			}
		} else {
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

	function validateDate($datenow, $sqldate)
	{
		$days = 0;
		$datenow = strtotime($datenow);
		$sqldate = strtotime($sqldate);

		$datediff = $sqldate - $datenow;

		$days = abs(round($datediff / (60 * 60 * 24)));

		return $days;
	}

	function getDays($now, $sqldate)
	{

		$datediff = $sqldate - $now;

		$days = abs(round($datediff / (60 * 60 * 24)));

		echo $days . " days";
	}

	function check_password($pass, $conpass)
	{
		if ($pass == $conpass) {
			return true;
		} else
			return false;
	}

	$message = '<strong>Welcome ' . base64_decode($_COOKIE['user']) . '</strong>';

	// RESET PASSWORD
	if (isset($_POST["resetPassword"])) {
		$email = base64_encode($_POST["forgotemail"]);
		$newpassword = $_POST["newpassword"];
		$connewpassword = $_POST["connewpassword"];

		// checkPasswords($email, $conn);

		$sql = "SELECT * FROM users WHERE email = '$email'";
		$list = $conn->query($sql);
		if ($email != "" and $newpassword != "") {
			if (check_password($newpassword, $connewpassword)) {
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
				$message = '<div class="alert alert-danger"> Passwords do not match </div>';
			}
		} else {
			$message = '<strong> There must be no empty inputs. </strong>';
		}
	}
	?>
	<!-- Nav -->
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

	<!--Profile card-->
	<div class="text-center">
		<div class="container">
			<div class="my-card">
				<div class="row g-0 justify-content-center">
					<div class="col-lg align-self-center">
						<img src="./about/merin.jpg" class="mx-auto d-block img-circle" alt="profile picture">
					</div>
					<div class="col-lg-5">
						<div class="" id=profile></div>
					</div>
					<div class="col-lg align-self-center">
						<div class="profile2">
							<p>Keep your account secure by regulary changing your password</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--End of profile card-->

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
						<h5 class="brand" id="staticBackdropLabel">Enter your new Password</h5>
					</div>
					<div class="modal-body">
						<div class="container">
							<!-- <span><?php echo $message; ?></span> -->

							<label for="forgotemail" class="form-label" style="color: red">Email Address</label>
							<div class="input-group flex-nowrap mb-3">
								<input type="email" class="form-control" placeholder="Email" id="forgotemail" name="forgotemail" value="<?php echo base64_decode($_COOKIE['email']) ?>" readonly>
								<label class="input-group-text" id="addon-wrapping" for="email"><i class="fas fa-user fa-1x p-2"></i></label>
							</div>
							<!--NEW PASSWORD -->
							<label for="password" class="form-label" style="color: red">Enter New Password</label>
							<div class="input-group flex-nowrap mb-3">
								<input type="password" class="form-control" placeholder="Enter New Password" id="newpassword" name="newpassword" value="">
								<label class="input-group-text" id="addon-wrapping" for="newpassword"><i class="fas fa-lock fa-1x p-2"></i></label>
							</div>

							<!--REPEAT PASSWORD -->
							<label for="repassword" class="form-label"> Confirm Password</label>
							<div class="input-group flex-nowrap mb-3">
								<input type="password" class="form-control" placeholder="Confirm Password" id="repeatpassword" name="repeatpassword" value="">
								<label class="input-group-text" id="addon-wrapping" for="password"><i class="fas fa-lock fa-1x p-2"></i></label>
							</div>


							<div class="center">
								<div class="g-recaptcha" data-sitekey="6LeQ6qEeAAAAAHoVDImiuHU2_-kC7kkIyPrtbhtU"></div>
							</div>
						</div>
					</div>

					<div class="modal-footer center">
						<button type="submit" class="btn btn-dark" name="resetPassword">Reset</button>
					</div>

				</form>

			</div>
		</div>
	</div>
	</div>
	<!--End Posted Recipes-->

	<!--Kenneth Recipes-->
	<div class="recipes_container active">
		<h5 class="fw-bold">Created Recipes</h5>
		<!-- <div class="btn_container">
			<button class="my-btn active" data-target="#streetDishes">Street Foods</button>
			<button class="my-btn" data-target="#dishDishes">Dish</button>
			<button class="my-btn" data-target="#dessertDishes">Dessert</button>
		</div> -->

		<!-- <form action="recipedetail.php" method="POST">
			<div id="streetDishes" class="recipe_list active">
			</div>
		</form>

		<form action="recipedetail.php" method="POST">
			<div id="dishDishes" class="recipe_list">
			</div>
		</form>

		<form action="recipedetail.php" method="POST">
			<div id="dessertDishes" class="recipe_list">
			</div>
		</form> -->
		<form action = "recipedetail.php" method = "POST">
			<div id="profileDishes" class="recipe_list active">
			</div>
		</form>
	</div>
	<!--End of Kenneth Recipes-->

	<!--Footer-->
	<div class="background-design2">
		<footer class="page-footer">
			<p>&#169; All Tasty. All right reserved.</p>
		</footer>
	</div>
	<!--End of Footer-->

	<!--Kenneth js-->
	<script src="script.js"></script>

	</div>
</body>

</html>

<script>
	/* kenneth scripts */
	Load();

	function Load() {
		$.ajax({
			url: "./getrecipe.php",
			type: "POST",
			success: function(response) {
				response.forEach(function(recipe, index) {
					if (recipe.user_id == getCookie("id")){
						var cooktime = recipe.cook_time + ' mins';
						if (recipe.cook_time > 60) {
							cooktime = ' ' + Math.round(recipe.cook_time / 60) + ' hours';
							if (recipe.cook_time % 60 > 0) {
								cooktime += ' ' + (recipe.cook_time % 60) + ' mins';
							}
						}

						// if (recipe.category == "street") {
						// 	$("#profileDishes").append('<div class = "recipe"><button class = "recipeButton" name = "button" value = ' + recipe.recipe_id + ' ><img src="./assets/' + recipe.img_name + '" class="img recipe-img"><p class = "Author">Author: ' + atob(recipe.firstname) + '</p> <div class = "flexStar" id = "' + index + '"> </div> <h5>' + recipe.recipe_name + '</h5><p> Cook time: ' + cooktime + '</p></button> </div>');
						// } else if (recipe.category == "dish") {
						// 	$("#profileDishes").append('<div class = "recipe"><button class = "recipeButton" name = "button" value = ' + recipe.recipe_id + ' ><img src="./assets/' + recipe.img_name + '" class="img recipe-img"><p class = "Author">Author: ' + atob(recipe.firstname) + '</p> <div class = "flexStar" id = "' + index + '"> </div> <h5>' + recipe.recipe_name + '</h5><p> Cook time: ' + cooktime + '</p></button> </div>');
						// } else {
						// 	$("#profileDishes").append('<div class = "recipe"><button class = "recipeButton" name = "button" value = ' + recipe.recipe_id + ' ><img src="./assets/' + recipe.img_name + '" class="img recipe-img"><p class = "Author">Author: ' + atob(recipe.firstname) + '</p> <div class = "flexStar" id = "' + index + '"> </div> <h5>' + recipe.recipe_name + '</h5><p> Cook time: ' + cooktime + '</p></button> </div>');
						// }

						$("#profileDishes").append('<div class = "recipe"><button class = "recipeButton" name = "button" value = ' + recipe.recipe_id + ' ><img src="./assets/' + recipe.img_name + '" class="img recipe-img"><p class = "Author">Author: ' + atob(recipe.firstname) + '</p> <div class = "flexStar" id = "' + index + '"> </div> <h5>' + recipe.recipe_name + '</h5><p> Cook time: ' + cooktime + '</p></button> </div>');
						$('#profileDishes').append('<input type="hidden" name="previouspage" value="./profilepage.php">');
					}
				});
				for (let i = 0; i < response.length; i++) {
					average = response[i].average;
					if (average == null) {
						$('#' + i + '').append('<p2 class = "average" >0.0</p2>');
					} else {
						$('#' + i + '').append('<p2 class = "average" > ' + parseFloat(average).toFixed(1) + '</p2>');
					}
					for (let j = 0; j < Math.trunc(average); j++) {
						$('#' + i + '').append('<span class = "fa fa-star" style = "color: #ff0038"></span>');
					}
					for (let k = 0; k < (5 - Math.trunc(average)); k++) {
						$('#' + i + '').append('<span class = "fa fa-star" style = "color: black"></span>');
					}
				}
			}
		});
	}

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

	function loadProfile(id) {
		$.ajax({
			url: "./loadprofile.php",
			type: "POST",
			data: {
				"id": (id),
			},
			success: function(response) {
				var firstname = atob(response[0].firstname);
				var lastname = atob(response[0].lastname);
				var email = atob(response[0].email);
				// document.cookie = "email="+response[0].email;

				// $("#profile").append('<h1>'+recipe.recipe_name+'</h1> <p>'+recipe.recipe_description+'</p> <div class="time-grid">  <div id = "recipeServings" class="time-square-1"> <div class="time-title-1">Serving</div> <div class="time-alotted">'+recipe.servings+' servings</div></div><div id = "recipeTime" class="time-square-2"><div class="time-title-2">Cook</div><div class="time-alotted">'+cooktime+'</div></div></div>')
				// <p class="profile-name"> </p>
				$("#profile").append('<p class="profile-name underline">' + firstname + ' ' + lastname + '</p>');
				$("#profile").append('<p class="profile-info">Life is awesome! Make your life tasty with All Tasty.</p>');
				$(".profile2").append('<p class="underline">' + email + '</p>');
				$(".profile2").append('<a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalResetPass"> Reset Password </a>');
			}
		});
	}

	loadProfile(getCookie('id'));
</script>