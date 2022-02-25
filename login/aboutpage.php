<html>

<head>
    <link rel="stylesheet" href="about/aboutpage.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Playfair+Display:400,500,600,700,800,900|Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
</head>
<body>
    <div class = "container">
        <div class="navbar">
            <div class="logo">
                <h1>All Tasty</h1>
            </div>
            
            <div id = "loginForm" class = "test">
            </div>
        </div>
    </div>
    <section>
        <main class="main-grid"> 
            <div class="main-text">
                <h2 class="section-title">Our Purpose</h2>
                <p>We want the rest of the world to know how delicious Filipino food is. Creating a website is one way for us to spread our recipes around the world and encourage people to try them. Filipino dishes are distinguished by distinct flavors and textures rather than by different courses. Instead of serving courses separately, they are all brought to the table at the same time so that diners can enjoy all flavors and dishes at the same time.</p>
            </div>
        </main>

        <div class="section-heading-block">
            <h4 class="section-title">
                Meet Our Team
            </h4>
        </div>

        <div class="timeline">
            <ul>
                <li>
                    <div class ="content">
                        <h2>Maria Gwyneth Bernardez</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur ratione alias necessitatibus repellat aut provident? Cum nihil a explicabo qui natus placeat, beatae illo, at tenetur laudantium rem dolorem iusto.</p>
                    </div>
                </li>
                <li>
                    <div class ="content">
                        <h2>Angel Lyka Latoza</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur ratione alias necessitatibus repellat aut provident? Cum nihil a explicabo qui natus placeat, beatae illo, at tenetur laudantium rem dolorem iusto.</p>
                    </div>
                </li>
                <li>
                    <div class ="content">
                        <h2>Jan Kyle Merin</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur ratione alias necessitatibus repellat aut provident? Cum nihil a explicabo qui natus placeat, beatae illo, at tenetur laudantium rem dolorem iusto.</p>
                    </div>
                </li>
                <li>
                    <div class ="content">
                        <h2>Alvin Patricio</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur ratione alias necessitatibus repellat aut provident? Cum nihil a explicabo qui natus placeat, beatae illo, at tenetur laudantium rem dolorem iusto.</p>
                    </div>
                </li>
                <li>
                    <div class ="content">
                        <h2>Kenneth Rada</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur ratione alias necessitatibus repellat aut provident? Cum nihil a explicabo qui natus placeat, beatae illo, at tenetur laudantium rem dolorem iusto.</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    
</body>

</html>

<script>

    
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
        $("#loginForm").append('<a href="./aboutpage.php"><button id = "logoutBtn" class="logout">Log Out</button></a>');
        $("#navigation").append('<li><a href="../form/addrecipe.php">Create Recipe</a></li>');
    }
    else{
        $("#loginForm").append('<a href = "./index.php">Log In</a>');
    }
    $("#logoutBtn").click(function(){
        if (username != ""){
            document.cookie = `user= ;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
        }
    });
</script>

