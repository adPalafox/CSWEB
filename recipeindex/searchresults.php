<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display:400,500,600,700,800,900|Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/9a3c6f8e27.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
</head>


<body>
    <section class="page">
        <div class="container">
        <div class="navbar">
                <div class="logo">
                    <img width="70px" src="./assets/All-Tasty.png" alt="">
                    <h1>All Tasty</h1>
                </div>

                <div id = "navigation" class="navs">
                    <li><a href="./home/index.php">Home</a></li>
                    <li><a href="./index.php">Recipes</a></li>
                    <li><a href="./about/aboutpage.php">About</a></li>
                </div>

                <div id = "loginForm" class = "test">
                </div>
            </div>


            <nav class="search">
                <form action="searchresults.php" method = "POST">
                    <input name = "search" type="text" placeholder="Search...">
                    <button><span class="fas fa-search"></span></button>
                </form>
                
            </nav>
        </div>
        <div class="recipes_container active">
            <div><p style = "font-size: 20px">SEARCH RESULTS FOR KEYWORD: <?= $_POST['search']?></p></div>
            <form action = "recipedetail.php" method = "POST">
                <div id = "searchList" class="recipe_list active">
                </div>
            </form>
            </div>
        </div>

    </section>
    <script src="script.js"></script>
</body>

</html>

<script>
    var searchResult = '<?= $_POST['search']?>'.toLowerCase();
    searchResults();
    function searchResults(){
        $.ajax({
        url: "./getrecipe.php",
        type: "POST",
        success: function(response){
            response.forEach(function (recipe, index){
                    if (((recipe.recipe_name).toLowerCase()).match(searchResult)){
                        var cooktime = recipe.cook_time + ' mins';
                        if (recipe.cook_time > 60){
                            cooktime = ' ' + Math.round(recipe.cook_time/60) + ' hours';
                            if (recipe.cook_time % 60 > 0){
                                cooktime += ' ' + (recipe.cook_time % 60) + ' mins';
                            }
                        }
                        $("#searchList").append('<div class = "recipe"><button class = "recipeButton" name = "button" value = '+recipe.recipe_id+' ><img src="./assets/'+recipe.img_name+'" class="img recipe-img"><p class = "Author">Author: '+recipe.username+'</p> <div class = "flexStar" id = "'+index+'"> </div> <h5>'+recipe.recipe_name+'</h5><p> Cook time: '+cooktime+'</p></button> </div>');
                    }
                });
                for(let i = 0; i < response.length; i++){
                    average = response[i].average;
                    if(average == null){
                        $('#'+i+'').append('<p2 class = "average" >0.0</p2>');
                    }
                    else{
                        $('#'+i+'').append('<p2 class = "average" > '+parseFloat(average).toFixed(1)+'</p2>');
                    }
                    for(let j = 0; j < Math.trunc(average); j++){
                        $('#'+i+'').append('<span class = "fa fa-star" style = "color: #ff0038"></span>');
                    }
                    for(let k = 0; k < (5 - Math.trunc(average)); k++){
                        $('#'+i+'').append('<span class = "fa fa-star" style = "color: black"></span>');
                    }
                }
            }
        });
    }
    function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
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
    if (username != ""){
        $("#loginForm").append('<a> '+username+'</a>');
        $("#loginForm").append('<a href="/recipeindex/index.php"><button id = "logoutBtn" class="logout">Log Out</button></a>');
        $("#navigation").append('<li><a href="/recipeindex/form/addrecipe.php">Create Recipe</a></li>');
    }
    else{
        $("#loginForm").append('<a href = "/recipeindex/login/login.php">Log In</a>');
        $("#loginForm").append('<a href = "/recipeindex/login/signup.php"><button class="signup">Sign Up →</button></a>');
    }
    $("#logoutBtn").click(function(){
        if (username != ""){
            document.cookie = `user= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
        }
    });
</script>