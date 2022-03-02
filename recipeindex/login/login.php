 <?php
	include("endpoints/db.php");
	$attempts = 0;
	$maxattempts = 3;
	$expireResult = "";
	$message = '';


	//$message = '<div class="alert alert-danger"><span id = "time"> Attempt Limit Reached!</span></div>';

	// function checkExpire($seconds)
	// {
	// 	$currentSeconds = time() - $seconds;

	// 	$minutes = $currentSeconds / 60;
	// 	$hours = $minutes / 60;
	// 	$days = $hours / 24;

	// 	return abs($days);
	// }

	// $sql = "SELECT * FROM users";
	// $list = $conn->query($sql);
	// if ($list->num_rows > 0) {
	// 	$result = $list->fetch_all(MYSQLI_ASSOC);
	// 	foreach ($result as $row) {
	// 		$days = checkExpire($row['expire']);
	// 		if ($days >= 20 and $days <= 30) {
	// 			$daysleft = 30 - ((int)$days);
	// 			$expireResult .= $row['email'] . ' is about to expire in (' . (int)$daysleft . ' days)<br>';
	// 			$message = '<div class="alert alert-danger">' . $expireResult . ' </div>';
	// 		} else if (checkExpire($row['expire']) > 30) {
	// 			$expireResult .= $row['email'] . ' has expired (' . (int)$days . ' days)<br>';
	// 			$message = '<div class="alert alert-danger">' . $expireResult . ' </div>';
	// 		}
	// 	}
	// }

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

	if (isset($_POST["loginAccount"])) {
		if (!isset($_COOKIE['attempt'])) {
			$_COOKIE['attempt'] = 0;
		}

		if ($_COOKIE['attempt'] >= $maxattempts) {
			// $_SESSION['error'] = 'Attempt limit reach';
			// $message = '<div class="alert alert-danger"> Attempt Limit Reached: (' . ($_SESSION["attempt"] + 1) . "/" . $maxattempts . ')</div>';
			$message = '<div class="alert alert-danger"><span id = "time"> Login Attempt Limit Reached!</span></div>';
		} else {
			$email = $_POST['email'];
			$hashedemail = base64_encode($email);
			$sql = "SELECT * FROM users WHERE email = '$hashedemail'";
			$list = $conn->query($sql);
			if ($list->num_rows > 0) {
				$result = $list->fetch_all(MYSQLI_ASSOC);
				foreach ($result as $row) {
					//$days = checkExpire($row['expire']);
					// setcookie("DAYS", $days, time() + 3600);
					// setcookie("Expiration", $passwordExpirationDays, time() + 3600);
					// if ($days <= $passwordExpirationDays) {
					// 	$hashedpassword = base64_encode($_POST['password']);
					// 	if ($hashedpassword == $row['password']) {
					// 		//Successful Login - ZenocyFox21234@
					// 		$_SESSION['success'] = 'Login successful';
					// 		unset($_SESSION['attempt']);
					// 		setcookie("accountid", $row["id"], time() + 3600);
					// 		header("location:../home/index.php");
					// 	} else {
					// 		$_SESSION['error'] = 'Password incorrect';
					// 		$_SESSION['attempt'] += 1;
					// 		if ($_SESSION['attempt'] == $maxattempts) {
					// 			//5*60 = 5mins, 60*60 = 1hour, 2*60*60 = 2hours
					// 			$_SESSION['attempt_again'] = time() + (5 * 60);
					// 		}
					// 		$message = '<div class="alert alert-danger"> Incorrect Login: (' . $_SESSION["attempt"] . "/" . $maxattempts . ')</div>';
					// 	}
					// } else {
					// 	$message = '<div class="alert alert-danger"> Password has expired for ' . $row['email'] . '<br>' . (int) $days . ' days has passed</div>';
					// }
					$hashedpassword = base64_encode($_POST['password']);
					if ($hashedpassword == $row['password']) {
						$datenow = date('Y-m-d');
						$dayspassed = validateDate($datenow, base64_decode($row['date']));
						if ($dayspassed > 30) {
							$message = '<div class="alert alert-danger"> The password for this account has expired! </div>';
						} else {
							//Successful Login
							setcookie("user", $row['firstname'], time() + 3600, '/', NULL, 0);
							setcookie("id", $row['id'], time() + 3600, '/', NULL, 0);
							setcookie("email", $row['email'], time() + 3600, '/', NULL, 0);
							setcookie("attempt", 0, time() + 3600);
							$message = '<div class="alert alert-danger"> Login Successful! </div>';
							header("location:../home/index.php");
						}
					} else {
						// Password Incorrect
						$attempts = $_COOKIE['attempt'] + 1;
						setcookie("attempt", $attempts, time() + 3600);
						if ($attempts == $maxattempts) {
							//5*60 = 5mins, 60*60 = 1hour, 2*60*60 = 2hours
							$message = '<div class="alert alert-danger"><span id = "time"> Attempt Limit Reached!</span></div>';
							setcookie("timer", 60 * 5, time() + 3600);
						} else {
							$message = '<div class="alert alert-danger"> Incorrect Login: (' . $attempts . "/" . $maxattempts . ')</div>';
						}
					}
				}
			} else {
				$attempts = $_COOKIE['attempt'] + 1;
				setcookie("attempt", $attempts, time() + 3600);
				$message = '<div class="alert alert-danger"> Incorrect Login: (' . $attempts . "/" . $maxattempts . ')</div>';
				if ($attempts == $maxattempts) {
					//5*60 = 5mins, 60*60 = 1hour, 2*60*60 = 2hours
					$message = '<div class="alert alert-danger"><span id = "time"> Attempt Limit Reached!</span></div>';
					setcookie("timer", 60 * 5, time() + 3600);
				}
			}
		}
	}


	// function checkPasswords($checkemail, $conn){
	// 	$prevPasswords = new SplFixedArray(6);
	// 	$sql = "SELECT * FROM passwords WHERE email = '$checkemail'";
	// 	$list = $conn->query($sql);
	// 	if ($list->num_rows > 0){
	// 		$result = $list->fetch_all(MYSQLI_ASSOC);
	// 		foreach ($result as $row){
	// 			// echo $row['email']."<br>";
	// 			// echo $row['password1']."<br>";
	// 			// echo $row['password2']."<br>";
	// 			// echo $row['password3']."<br>";
	// 			// echo $row['password4']."<br>";
	// 			// echo $row['password5']."<br>";
	// 			// echo $row['password6']."<br>";
	// 			for($i = 1; $i <= 6; $i++){
	// 				$counter = 'password'.$i;
	// 				echo $row[$counter].'<br>';
	// 				// if($row[$counter] != ""){
	// 				// 	echo "fuck ".$row[$counter]." <br>";
	// 				// }else{
	// 				// 	echo "empty sht".$row[$counter]."<br>";
	// 				// }
	// 			}
	// 		}
	// 	}
	// }

	// checkPasswords("curfyfox@gmail.com", $conn);



	if (isset($_POST["createAccount"])) {
		$fname = $_POST['createfname'];
		$lname = $_POST['createlname'];
		$email =  base64_encode($_POST['createemail']);
		$password = $_POST['createpassword'];
		$date = date("Y-m-d");
		$result = passwordValidation($fname, $lname, $password, $conn);

		$SecretKey = '6LeQ6qEeAAAAAOg8CaomIHC1aAAU6ekIzfO39SNI';
		$ResponseKey = $_POST['g-recaptcha-response'];
		$userIP = $_SERVER['REMOTE_ADDR'];

		$url = "https://www.google.com/recaptcha/api/siteverify?secret=$SecretKey&response=$ResponseKey&remoteip=$userIP";
		$response = file_get_contents($url);

		if ($fname != "" and $lname != "" and $email != "" and $password != "") {
			if ($_POST["g-recaptcha-response"] != '') {
				if (!existingAccount($conn, $email)) {
					if (strlen($result) <= 0) {
						$fname = base64_encode($fname);
						$lname = base64_encode($lname);
						$password = base64_encode($password);
						$date = base64_encode($date);
						$sql = "INSERT INTO users (firstname, lastname, email, password, date) VALUES ('$fname', '$lname', '$email', '$password', '$date');";
						if ($conn->query($sql) === TRUE) {
							setcookie("page", "login", time() + 3600);
							$result = 'Account successfully created!';

							// $passwordSql = "INSERT INTO passwords (email, password1, password2, password3, password4, password5, password6) VALUES ('$email', '$password', ' ', ' ', ' ', ' ', ' ');";
							// if ($conn->query($passwordSql) === TRUE) {
							// }
						} else {
							echo "Error: " . $sql . "<br>" . $conn->error;
						}
						$conn->close();
					}
				} else {
					$result .= "\nEmail Account Address is already being used.";
				}
				$message = '<div class="alert alert-danger">' . $result . '</div>';
			} else {
				$message = '<div class="alert alert-danger"> Please verify captcha. </div>';
			}
		} else {
			$message = '<div class="alert alert-danger"> There must be no empty inputs. </div>';
		}
	}

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
								$message = '<div class="alert alert-danger"> Account Password Successfully Updated </div>';
							} else {
								echo "Error: " . $sql . "<br>" . $conn->error;
							}
							$conn->close();
						}
					}
				} else {
					$message = '<div class="alert alert-danger"> Please verify captcha. </div>';
				}
			} else {
				$message = '<div class="alert alert-danger"> Account Does Not Exist! </div>';
			}
		} else {
			$message = '<div class="alert alert-danger"> There must be no empty inputs. </div>';
		}
	}
	?>
 <html>

 <head>
 	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

 	<script>
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
 		$(document).ready(function() {
 			if (getCookie("page") == "login") {
 				$("#loginModule").modal('show');
 			} else if (getCookie("page") == "create") {
 				$("#createModule").modal('show');
 			} else if (getCookie("page") == "forgot") {
 				$("#forgotModule").modal('show');
 			}
 		});
 	</script>
 </head>

 <body>
 	<!-- LOGIN MODULE -->
 	<div class="modal fade" id="loginModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 		<div class="modal-dialog modal-dialog-centered">
 			<div class="modal-content">
 				<form action="index.php" method="POST">
 					<div class="modal-header justify-content-center">
 						<h5 class="brand" id="staticBackdropLabel">Login</h5>
 					</div>
 					<div class="modal-body">
 						<div class="container">
 							<h4 class="mb-3 fw-bold  text-center">Login to start your session</h4>
 							<span><?php echo $message; ?></span>
 							<label for="email" class="form-label">Email address</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="email" class="form-control" placeholder="Email" id="email" name="email" value="">
 								<label class="input-group-text" id="addon-wrapping" for="email"><i class="fas fa-user fa-1x p-2"></i></label>
 							</div>
 							<label for="password" class="form-label">Password</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="password" class="form-control" placeholder="Password" id="password" name="password" value="">
 								<label class="input-group-text" id="addon-wrapping" for="password"><i class="fas fa-lock fa-1x p-2"></i></label>
 							</div>
 						</div>
 					</div>

 					<div class="modal-footer justify-content-between mx-3 my-2">
 						<button type="submit" class="btn " name="pageSelect" value="create">Create an account</button>
 						<button type="submit" class="btn " name="pageSelect" value="forgot">Change Password</button>
 						<button type="submit" class="btn btnSquare bg-dark" name="loginAccount">Login</button>
 					</div>
 				</form>
 				<!-- <form action="index.php" method="POST">
 			</form> -->

 			</div>
 		</div>
 	</div>

 	<!-- CREATE ACCOUNT MODULE -->
 	<div class="modal fade" id="createModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 		<div class="modal-dialog modal-dialog-centered">
 			<div class="modal-content">
 				<form action="index.php" method="POST">
 					<div class="modal-header justify-content-center">
 						<h5 class="brand" id="staticBackdropLabel">Create Account</h5>
 					</div>
 					<div class="modal-body">
 						<div class="container">
 							<h4 class="mb-3 fw-bold  text-center">Start creating your account now!</h4>
 							<span><?php echo $message; ?></span>

 							<!-- FIRST NAME -->
 							<label for="fname" class="form-label">First Name</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="text" class="form-control" placeholder="First Name" id="createfname" name="createfname" value="">
 								<label class="input-group-text" id="addon-wrapping" for="fname"><i class="fas fa-user fa-1x p-2"></i></label>
 							</div>

 							<!-- LAST NAME -->
 							<label for="lname" class="form-label">Last Name</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="text" class="form-control" placeholder="Last Name" id="createlname" name="createlname" value="">
 								<label class="input-group-text" id="addon-wrapping" for="lname"><i class="fas fa-user fa-1x p-2"></i></label>
 							</div>

 							<!-- EMAIL -->
 							<label for="email" class="form-label">Email address</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="email" class="form-control" placeholder="Email" id="createemail" name="createemail" value="">
 								<label class="input-group-text" id="addon-wrapping" for="email"><i class="fas fa-user fa-1x p-2"></i></label>
 							</div>

 							<!-- PASSWORD -->
 							<label for="password" class="form-label">Password</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="password" class="form-control" placeholder="Password" id="createpassword" name="createpassword" value="">
 								<label class="input-group-text" id="addon-wrapping" for="password"><i class="fas fa-lock fa-1x p-2"></i></label>
 							</div>
 							<div class="center">
 								<div class="g-recaptcha" data-sitekey="6LeQ6qEeAAAAAHoVDImiuHU2_-kC7kkIyPrtbhtU"></div>
 							</div>
 						</div>
 					</div>

 					<div class="modal-footer justify-content-between mx-3 my-2">
 						<button type="submit" class="btn " name="pageSelect" value="login">Already have an account?</button>
 						<button type="submit" class="btn btnSquare bg-dark" name="createAccount">Create Account</button>

 					</div>
 				</form>
 			</div>
 		</div>
 	</div>

 	<!-- FORGOT MODULE -->
 	<div class="modal fade" id="forgotModule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
 		<div class="modal-dialog modal-dialog-centered">
 			<div class="modal-content">
 				<form action="index.php" method="POST">
 					<div class="modal-header justify-content-center">
 						<h5 class="brand" id="staticBackdropLabel">Forgot Password</h5>
 					</div>
 					<div class="modal-body">
 						<div class="container">
 							<h4 class="mb-3 fw-bold  text-center">Enter your email address</h4>
 							<span><?php echo $message; ?></span>

 							<label for="forgotemail" class="form-label" style="color: red">Enter Email Address</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="email" class="form-control" placeholder="Email" id="forgotemail" name="forgotemail" value="">
 								<label class="input-group-text" id="addon-wrapping" for="email"><i class="fas fa-user fa-1x p-2"></i></label>
 							</div>

 							<label for="password" class="form-label" style="color: red">Enter New Password</label>
 							<div class="input-group flex-nowrap mb-3">
 								<input type="password" class="form-control" placeholder="Enter New Password" id="newpassword" name="newpassword" value="">
 								<label class="input-group-text" id="addon-wrapping" for="newpassword"><i class="fas fa-lock fa-1x p-2"></i></label>
 							</div>
 							<div class="center">
 								<div class="g-recaptcha" data-sitekey="6LeQ6qEeAAAAAHoVDImiuHU2_-kC7kkIyPrtbhtU"></div>
 							</div>
 						</div>
 					</div>

 					<div class="modal-footer justify-content-between mx-3 my-2">
 						<button type="submit" class="btn " name="pageSelect" value="login">Login to Account</button>
 						<button type="submit" class="btn btnSquare bg-dark" name="resetPassword">Reset</button>
 					</div>

 				</form>

 			</div>
 		</div>
 	</div>

 	<script>
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

 		function startTimer(duration, display) {
 			var timer = duration,
 				minutes, seconds;
 			var fullseconds = duration;
 			setInterval(function() {
 				minutes = parseInt(timer / 60, 10);
 				seconds = parseInt(timer % 60, 10);

 				minutes = minutes < 10 ? "0" + minutes : minutes;
 				seconds = seconds < 10 ? "0" + seconds : seconds;

 				display.textContent = "Try again in: " + minutes + ":" + seconds;
 				document.cookie = 'timer=' + --fullseconds;
 				if (--timer < 0) {
 					//timer up!!
 					timer = 0;
 					window.location = window.location.href;
 					document.cookie = 'attempt=' + 0;
 				}
 			}, 1000);
 		}

 		function getTimer() {
 			var timer = getCookie("timer");
 			var attempts = getCookie("attempt");
 			if (timer <= 0) {
 				document.cookie = 'timer=' + 0;
 			}
 			if (attempts >= 3) {
 				var timer = getCookie("timer");
 				display = document.querySelector('#time');
 				startTimer(timer, display);
 			}
 		}
 		getTimer();
 	</script>

 </body>



 </html>