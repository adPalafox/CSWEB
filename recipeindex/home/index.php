<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Love+Ya+Like+A+Sister&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
</head>

<body>
    <section class="page">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <img width="70px" src="All-Tasty-.png" alt="">
                    <h1>All Tasty</h1>
                </div>

                <div id=navigation class="navs">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="../index.php">Recipes</a></li>
                    <li><a href="../about/aboutpage.php">About</a></li>
                </div>

                <div id="loginForm" class="loginForms">
                </div>
            </div>
            <div class="landing-page">
                <div class="head-title">
                    Kenneth Rada was here
                    <p class="head-second-title">Tips | Techniques | Tricks</p>
                </div>
                <div class="row">
                    <div class="column">
                        <img class="left" src="lettuce.png">
                        <img class="leftcenter" src="garlicleft.png">
                        <img class="center" src="bulalo2.png">
                        <img class="rightcenter" src="mushcenter.png">
                        <img class="rightcenter2" src="cilantro.png">
                        <img class="rightcenter3" src="parsley.png">
                        <img class="right" src="broccoliright.png">
                    </div>
                </div>
            </div>
        </div>




        <!-- SECOND CONTENT -->
        <div class="background-design">
            <div>
                <div class="background-image">
                    <img class="background-image-left" src="design2.png">
                    <img class="background-image-right" src="design3.png">
                </div>

                <div class=content-background>
                    <div class="selection">
                        <h1 class="second-title">Explore Traditional Filipino Foods</h1>
                        <p class="subtitle"> Filipino food is characterized by the combination of three flavors – sweet, sour, and salty. <br>
                            When there are a lot of sawsawan (dips) on the table, the meal is complete. <br>
                            It is commonly said that one can tell when a Filipino is dining if the diner requires a variety of dips. <br>
                        </p>
                    </div>


                    <article class="content">
                        <div class="img-right">
                            <img class="content-image" src="https://static01.nyt.com/images/2018/03/14/dining/14FIlipino1-sub/14FIlipino1-sub-superJumbo.jpg">
                        </div>

                        <div class="content-text">
                            <div class="txt-right">
                                <h3 class="description-title"> Influences of Filipino Food </h3>
                                <p class="description-text"> Filipino cuisine is a mix of different influences.
                                    It has been shaped by centuries of migration and colonialism to become the multi-faceted cuisine that it is today.
                                    This cultural diversity is most visible in the way Filipinos cook and eat.
                                    From the Spanish colonizers to Chinese cuisine, brought along by the various traders.
                                </p>
                            </div>
                        </div>
                    </article>

                    <article class="content">
                        <div class="img-left">
                            <img class="content-image" src="https://i.imgur.com/MAj9Oy5.jpg">
                        </div>

                        <div class="content-text">
                            <div class="txt-left">
                                <h3 class="description-title"> Gaining Popularity Around the World </h3>
                                <p class="description-text"> Filipino cuisine is a mix of different influences.
                                    It has been shaped by centuries of migration and colonialism to become the multi-faceted cuisine that it is today.
                                    This cultural diversity is most visible in the way Filipinos cook and eat.
                                    From the Spanish colonizers to Chinese cuisine, brought along by the various traders.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>



        <h2 class="lists-title">Popular Dishes</h2>

        <div class="lists">
            <div class="box">
                <div class="imgBOX">
                    <img src="bulalo.png" id=item1>
                    <div class="infos">
                        <h5>Bulalo</h5>
                        <p>It’s a well known fact that Filipinos love stew and soup dishes. </p> <a href="#1">Read more...</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="imgBOX">
                    <img src="kare-kare.png" id=item1>
                    <div class="infos">
                        <h5>Kare-Kare</h5>
                        <p>It is a rich and peanut buttery oxtail and beef stew. </p> <a href="#2">Read more...</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="imgBOX">
                    <img src="sinigang.png" id=item1>
                    <div class="infos">
                        <h5>Sinigang</h5>
                        <p>It is a sour soup native that are simmered along tamarind fruit. </p> <a href="#3">Read more...</a>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="imgBOX">
                    <img src="adobo.png" id=item1>
                    <div class="infos">
                        <h5>Adobo</h5>
                        <p>It is undeniably one of the most iconic dishes from the Philippines. </p> <a href="#4">Read more...</a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="page-footer">
            <p>&#169; All Tasty. All right reserved.</p>
        </footer>
    </section>
</body>

</html>

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
    let username = getCookie("user");
    if (username != "") {
        $("#loginForm").append('<a href="../profilepage.php"> ' + username + '</a>');
        $("#loginForm").append('<a href="./index.php"><button id = "logoutBtn" class="signup">Log Out</button></a>');
        $("#navigation").append('<li><a href="../form/addrecipe.php">Create Recipe</a></li>');
    } else {
        $("#loginForm").append('<a href = "../login/login/index.php"><button id = "logoutBtn" class="signup">Log In</button></a>');
    }
    $("#logoutBtn").click(function() {
        if (username != "") {
            document.cookie = `user= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
        }
    });
</script>