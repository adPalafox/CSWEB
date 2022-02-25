<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://kit.fontawesome.com/9a3c6f8e27.js" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
	</head>
<body>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Recipe: Review System</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div>
				<h3>Rating:</h3>
				<span id="1" style="font-size:45px; cursor:pointer;"  class="fa fa-star" onmouseover="startRating(this)" startRating="starmark(this)" ></span>
				<span id="2"  style="font-size:45px; cursor:pointer;" class="fa fa-star" onmouseover="startRating(this)" startRating="starmark(this)"></span>
				<span id="3"  style="font-size:45px; cursor:pointer;" class="fa fa-star" onmouseover="startRating(this)" startRating="starmark(this)"></span>
				<span id="4"  style="font-size:45px; cursor:pointer;" class="fa fa-star" onmouseover="startRating(this)" startRating="starmark(this)"></span>
				<span id="5"  style="font-size:45px; cursor:pointer;" class="fa fa-star" onmouseover="startRating(this)" startRating="starmark(this)"></span>
			</div>
			<br />
			<div class="form-group">
				<h3>Review:</h3>
				<textarea id="review" class="form-control" style="resize:none; height:100px;"></textarea>
			</div>
			<center><button class="btn btn-success" onclick="result()">SUBMIT</button></center>
			<div id="result"></div>
		</div>
	</div>
</body>
</html>

<script>
	var count = 0;

	function result(){
		if(count != 0){
			document.getElementById('result').innerHTML = 
			"<h4>Rating: <label class='text-primary'>" + count + "</label></h4>"
			+ "<h4>Review</h4>"
			+ "<p>"+document.getElementById("review").value+"</p>";
		}else{
			
		}
	}

	function startRating(item){
		count=item.id[0];
		sessionStorage.star = count;
		for(var i=0;i<5;i++){
			if(i<count){
				document.getElementById((i+1)).style.color="yellow";
			}
			else{
				document.getElementById((i+1)).style.color="black";
			}
		}
	}
</script>