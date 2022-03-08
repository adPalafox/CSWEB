<?php
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
			<img class="clipart" src="clipart.png" />
		</div>
		<?php include 'login.php'; ?>
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
		padding-top: 30px;
	}

	.mycontainer .hero .logo {
		display: flex;
		align-items: center;
		position: relative;
	}

	.mycontainer .hero .logo h1 {
		font-size: 20px;
	}

	.clipart {
		position: absolute;
		bottom: 0;
		height: auto;
		width: 60%;
	}

	.container{
		overflow: hidden;
	}

	.form-control{
		padding: 10px;
		border-width: 1.5px;
	}

	.form-control:hover{
		border: 1.5px solid #4176fc;
	}

	.form-control:focus{
		border: 1.5px solid #4176fc;
		box-shadow: 0 0 0 3px #f2f5ff;
	}

	.form-label {
		font-weight: bolder;
	}

	.btn-password {
		border: none;
		background: white;
		font-size: 15px;
		color: #6c757d;
	}

	.btn-password:hover{
		text-decoration-color: #6c757d;
		text-decoration: underline;
    	text-underline-offset: .5px;
	}

	.buttons{
		display: flex;
		justify-content: space-between;
	}

	.btnSquare{
		border-radius: 20px;
	}

	.btn-signup{
		border: none;
		background: white;
		color: #de0c19;
		font-weight: bold;
		font-size: 15px;
	}

	.class-two{
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.policy{
		font-size: 15px;
		text-align: center;
		color: #6f6f6f;
		margin: 26px 0 0 0;
		line-height: 18px;
	}

	.btn-login{
		border: none;
		background: white;
		color: #de0c19;
		font-weight: bold;
		font-size: 15px;
	}
</style>