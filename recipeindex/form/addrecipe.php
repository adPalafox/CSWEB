<html>

<head>
    <link rel="stylesheet" href="addrecipe.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display:400,500,600,700,800,900|Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <img width="70px" src="../assets/All-Tasty.png" alt="">
                <h1>All Tasty</h1>
            </div>

            <div id="navigation" class="navs">
                <li><a href="../home/index.php">Home</a></li>
                <li><a href="../index.php">Recipes</a></li>
                <li><a href="../about/aboutpage.php">About</a></li>
            </div>

            <div id="loginForm" class="test">
            </div>
        </div>
    </div>
    <div class="formbg">
        <div class="formcontainer">
            <form action="upload.php" enctype="multipart/form-data" method="POST" class="addrecipe">
                <fieldset class="fieldset">
                    <legend style="text-align: center">
                        <div class="ttl">
                            <p>Add Recipe</p>
                        </div>
                    </legend>

                    <label class="textLabel" for="recipe_name">Recipe Name:</label>
                    <input class="textInput" type="text" id="recipe_name" name="recipe_name"><br><br>

                    <label class="textLabel" for="recipe_description">Recipe Description:</label>
                    <textarea style="height: 65px; resize: vertical; width: 100%; margin-top: 10px" id="recipe_description" id="" cols="50" rows="5" maxlength="280"></textarea>

                    <div class="ingre_box" id="ingr_box">
                        <span class="ingreLabel">Ingredients:
                            <button class="ingre_btn" id="subingr" type="button">-</button>
                            <button class="ingre_btn" id="addingr" type="button">+</button>
                        </span>
                        <input name="ingredients" id=x0 class="ingre" type="text">
                    </div>

                    <div class="steps_box" id="step_box">
                        <span class="stepLabel">Steps:
                            <button class="step_btn" id="substep" type="button">-</button>
                            <button class="step_btn" id="addstep" type="button">+</button>
                        </span>
                        <textarea name="steps" id=y0 class="steps" type="text"></textarea>
                    </div>

                    <div class="input_box">
                        <span class="stepLabel">Image: </span>
                        <input class="input_style" type="file" id="file" accept=".png">
                    </div>

                    <span class="textLabel">Cook Time: </span>
                    <input style="height: 25px; resize: vertical; width: 20%; margin-top: 10px" type="number" id="recipe_cook" name="recipe_cook" min="1"> mins<br><br>

                    <span class="textLabel">Servings</span>
                    <input style="height: 25px; resize: vertical; width: 20%; margin-top: 10px;" type="number" id="recipe_servings" name="recipe_servings" min="1"> servings<br><br>

                    <div class="categ_box">
                        <span class="textLabel">Category: </span>
                        <div class="radio-toolbar">
                            <input type="radio" id="radioStreet" name="radioCategory" value="street">
                            <label for="radioStreet">Street Foods</label>

                            <input type="radio" id="radioDishes" name="radioCategory" value="dish">
                            <label for="radioDishes">Dishes</label>

                            <input type="radio" id="radioDesserts" name="radioCategory" value="dessert">
                            <label for="radioDesserts">Desserts</label>
                        </div>
                    </div>


                    <div class="submitbtn">
                        <button id="submit" name="submit" class="recipesubmit"> Publish Recipe </button>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
</body>

<script src="script.js"></script>

</html>

<script>
    var user_id = '';
    var recipe_id = '';
    var recipe_name = '';
    var recipe_description = '';
    var recipe_servings = '';
    var recipe_cook = '';
    var recipe_img = '';
    var recipe_ingredients = [];
    var recipe_steps = [];
    var recipe_category = '';

    var getUserId = function(callback) {
        $.ajax({
            url: "getid.php",
            type: "POST",
            success: callback
        });
    }

    getUserId(function(data) {
        var currentAccount = getCookie("user");
        data.forEach(function(user, index) {
            if (currentAccount.toLowerCase() == (user.username).toLowerCase()) {
                user_id = user.id;
            }
        });
    });

    $('#submit').click(function(e) {
        e.preventDefault();
        recipe_owner = getCookie("user");
        recipe_id = Math.round((Date.now() * Math.random()));
        recipe_name = document.getElementById('recipe_name').value;
        recipe_description = document.getElementById('recipe_description').value;
        recipe_servings = '';
        recipe_cook = '';
        recipe_img = '';
        recipe_ingredients = [];
        recipe_steps = [];
        recipe_category = '';
        for (let i = 0; i < x; i++) {
            if (document.getElementById('x' + i) != "") {
                recipe_ingredients[i] = document.getElementById("x" + i).value;
            }
        }
        for (let i = 0; i < y; i++) {
            if (document.getElementById('y' + i) != "") {
                recipe_steps[i] = document.getElementById("y" + i).value;
            }
        }

        recipe_category = document.getElementsByName('radioCategory');
        for (let i = 0; i < recipe_category.length; i++) {
            if (recipe_category[i].checked) {
                recipe_category = recipe_category[i].value;
            }
        }
        recipe_cook = document.getElementById('recipe_cook').value;

        recipe_servings = document.getElementById('recipe_servings').value;

        // console.log(recipe_name);
        // console.log(recipe_description);
        // console.log(recipe_ingredients);
        // console.log(recipe_steps);
        // console.log(recipe_cook);
        // console.log(recipe_servings);
        uploadFile();
    });

    var counter = 0;

    function uploadIngredientDatabase() {
        console.log("Attempting to Upload Ingredient");
        console.log("INGREDIENTS: " + recipe_id);
        setTimeout(function() {

            if (counter < recipe_ingredients.length) {
                if (recipe_ingredients[counter] != "") {
                    var currentIngredient = recipe_ingredients[counter];
                    $.ajax({
                        url: "./insertingredient.php",
                        type: "POST",
                        data: {
                            "recipe_id": recipe_id,
                            "ingredient": currentIngredient,
                        },
                        success: function(response) {
                            if (response.code == '201') {
                                console.log('Created Successfully');
                            }
                            if (response.code == '400') {
                                console.log('Error');
                            }
                        }
                    });
                }
                uploadIngredientDatabase();
                counter++;
            }
        }, 10)
    }

    var stepCounter = 0;

    function uploadStepsDatabase() {
        console.log("STEPS: " + recipe_id);
        setTimeout(function() {
            if (stepCounter < recipe_steps.length) {
                if (recipe_steps[stepCounter] != "") {
                    var currentStep = recipe_steps[stepCounter];
                    $.ajax({
                        url: "./insertsteps.php",
                        type: "POST",
                        data: {
                            "recipe_id": recipe_id,
                            "steps": currentStep,
                        },
                        success: function(response) {
                            if (response.code == '201') {
                                console.log('Created Successfully');
                            }
                            if (response.code == '400') {
                                console.log('Error');
                            }
                        }
                    });
                }
                uploadStepsDatabase();
                stepCounter++;
            }
        }, 10)
    }

    function uploadFile() {
        console.log("UPLOAD: " + recipe_id);
        var files = document.getElementById("file").files;

        if (files.length > 0) {

            var formData = new FormData();
            formData.append("file", files[0]);
            formData.append("fileName", recipe_name);
            recipe_img = files[0].name;
            var xhttp = new XMLHttpRequest();


            xhttp.open("POST", "uploadimage.php", true);

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = this.responseText;
                    if (response == 1) {
                        //alert("Upload successfully.");
                        uploadRecipeDatabase();
                        uploadIngredientDatabase();
                        uploadStepsDatabase();
                        uploadRatingDatabase();
                        setTimeout(function() {
                            window.location.replace("../index.php");
                        }, 1000);
                    } else {
                        alert("Creating Recipe Failed.");
                    }
                }
            };
            xhttp.send(formData);
        } else {
            alert("Please select a file");
        }
    }

    function uploadRecipeDatabase() {
        $.ajax({
            url: "./insertdatabase.php",
            type: "POST",
            data: {
                "user_id": user_id,
                "recipe_id": recipe_id,
                "recipe_name": recipe_name,
                "recipe_description": recipe_description,
                "recipe_servings": recipe_servings,
                "recipe_cook": recipe_cook,
                "recipe_img": recipe_img,
                "recipe_category": recipe_category,
            },
            success: function(response) {
                if (response.code == '201') {
                    console.log('Created Successfully');
                    //uploadIngredientDatabase();
                }
                if (response.code == '400') {
                    console.log('Error');
                }
            }
        });
    }

    function uploadRatingDatabase() {
        $.ajax({
            url: "./insertrating.php",
            type: "POST",
            data: {
                "userId": user_id,
                "recipeId": recipe_id,
                "rating": 0,
                "comment": "",
            },
            success: function(response) {

            }
        });
    }

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
    let username = getCookie("user");
    if (username != "") {
        $("#loginForm").append('<a href="../profilepage.php"> ' + username + '</a>');
        $("#loginForm").append('<a href="./addrecipe.php"><button id = "logoutBtn" class="logout">Log Out</button></a>');
        $("#navigation").append('<li><a href="./addrecipe.php">Create Recipe</a></li>');
    } else {
        $("#loginForm").append('<a href = "../login/login/index.php">Log In</a>');
        $("#loginForm").append('<a href = "../login/login/index.php"><button class="signup">Sign Up →</button></a>');
    }
    $("#logoutBtn").click(function() {
        if (username != "") {
            document.cookie = `user= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
        }
    });
</script>