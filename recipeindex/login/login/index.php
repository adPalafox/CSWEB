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
	<!-- <div class="container">
		<?php include 'login.php'; ?>
	</div> -->
	<div class="container">
		<?php include 'login.php'; ?>
		<div class="hero">
			<div class="logo">
				<img src="All-Tasty-.png" width="70px" alt="">
				<h1>All Tasty</h1>
			</div>
			<img class="clipart" src="clipart.png" />
		</div>
	</div>
</body>

</html>

<style>
	@import url('https://fonts.googleapis.com/css?family=Roboto');

	/* *,
    *:before,
    *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    } */

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
		font-family: Roboto, Sans-serif;
		color: #010001;
		font-size: 14px;
		line-height: 25px;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	.container {
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
		padding-top: 30px;
	}

	.container .hero .logo {
		display: flex;
		align-items: center;
		position: relative;
	}

	.container .hero .logo h1 {
		font-size: 20px;
	}

	.clipart {
		position: absolute;
		bottom: 0;
		height: auto;
		width: 60%;
	}

</style>