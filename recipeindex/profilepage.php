<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="profilepagestyle.css">
</head>

<body class="body">

	<!-- Nav -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
				<!-- <form class="d-flex">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form> -->
			</div>
		</div>
	</nav>
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
						<div class="card-body">
							<p class="profile-name">Jan Andrew Latoza</p>
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In nihil beatae aspernatur ipsam quam debitis? </p>
							<p class="profile-info">jansample@gmail.com</p>
							<!-- Button trigger modal -->
							<a class="mylink" data-bs-toggle="modal" data-bs-target="#modalResetPass">
								Reset Password
							</a>
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

		<!-- Modal password -->
		<div class="modal fade" id="modalResetPass" tabindex="-1" aria-labelledby="modalResetPass" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Reset Password</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						asdfasdfasdf
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<!-- End of Modal -->
		<!-- Toast -->

		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
			<symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
				<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
			</symbol>
		</svg>
		<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
			<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto">Password Expiration</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body alert-warning">
					<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
						<use xlink:href="#exclamation-triangle-fill" />
					</svg>
					<strong>Sweet potato!</strong> You have <strong> 69 days left </strong>before your password expires
				</div>
			</div>
		</div>
		<!-- End of Toast -->
	</div>
	</div>
</body>

</html>

<script>
	var toastTrigger = document.getElementById('liveToastBtn')
	var toastLiveExample = document.getElementById('liveToast')
	var toast = new bootstrap.Toast(toastLiveExample)
	toast.show()
</script>