<?php

session_start();

// if(isset($_COOKIE["type"]))
// 	if($_COOKIE["type"]=="patient")
// 		header("location:logout.php");

// if(isset($_COOKIE["id"])){
// 	header("location:dashboard.php");
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="maximum-scale=1.0, width=device-width, initial-scale=1.0">
	<title>Login Module</title>

	<?php include 'assets/links.php'; ?>

</head>

<body>
	<div class="mycontainer">
		<div class="hero">
			<div class="logo">
				<img src="All-Tasty-.png" width="70px" alt="">
				<h1>All Tasty</h1>
			</div>
			<img class="clipart" src="clipart.png" />
		</div>
		<?php include 'login.php'; ?>
	</div>
</body>

</html>

<style>
	@import url("https://fonts.googleapis.com/css2?family=Dr+Sugiyama&display=swap");

	body,
	html {
		padding: 0;
		margin: 0;
		height: 100%;
		width: 100%;
		background-color: #fbd691;
		overflow: hidden;
	}

	body {
		color: #010001;
		font-size: 14px;
		line-height: 25px;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	.mycontainer {
		display: flex;
		flex-direction: row;
		height: 100%;
		width: 100%;
		padding-left: 20px;
	}

	.hero {
		display: flex;
		flex-direction: column;
		flex: 1;
		padding: 15px 50px;
	}

	.logo {
		
		padding-bottom: 75px;
		padding-top: 20px;
	}

	.mycontainer .hero .logo {
		display: flex;
		align-items: center;
		position: relative;
	}

	.mycontainer .hero .logo h1 {
		font-size: 2em;
	}

	.clipart {
		position: absolute;
		bottom: 0;
		left: -5%;
		height: auto;
		width: 50%;
	}
</style>