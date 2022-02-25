<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"> </script>
    </head>
    <body>
        <div class="container">
            <div class="hero">
                <div class="logo">
                    <img src="All-Tasty-.png" width="70px" alt="">
                    <h1>All Tasty</h1>
                </div>
                <img class ="clipart" src="clipart.png"/>
            </div>
        
            <div class="content">
                <h1 class="headline">Join Us!</h1>
                <div class="tabs">
                    <form action="#" method ="POST" class="login">
                        <div class="field">
                          <input type="text" class="input-half" id = "first_name" name = "first_name" placeholder="First Name" > 
                          <input type="text" class="input-half" id = "last_name" name = "last_name" placeholder="Last Name" >
                        </div>
                        <div class="field">
                          <input type="text" id = "username" name = "username" placeholder="Username">
                        </div>
                        
                        <div class="field">
                          <input type="password" id="password" name = "password" placeholder="Password">
                          <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </div>

                        <div class="input-checkbox__container"><br>
                            <input id="agree" tabindex="0" type="checkbox" />
                            <label for="agree"> By creating an account means you agree to the <b> Terms and Conditions</b>, and our <b> Privacy Policy</b></label>
                        </div>

                        <div class="field btn">
                          <div class="btn-layer"></div>
                          <input type="submit" id = "registerBtn" name="registerBtn" class = "registerBtn" value="Register"/>
                        </div>

                      <div class="footer_line">
                            <span class="footer_text">Already have an account?</span>
                            <a href = "./login.php"><span class="footer_link" id="login">Log In</span></a>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    $("#registerBtn").click(function(e){
        e.preventDefault();
        var username = document.getElementById("username").value;
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;
        var password = document.getElementById("password").value;
        $.ajax({
            url: "createaccount.php",
            type: "POST",
            data: {
                "username": username,
                "first_name": first_name,
                "last_name": last_name,
                "password": password
            },
            success: function(response){
                
                if(response.code == "success"){
                    console.log('success');
                    window.location.href='./login.php'
                }else{
                    console.log('invalid');
                }
            }
        });
    });
</script>


<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto');
*, *:before, *:after {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    }

body, html {
    padding: 0;
    margin: 0;
    height: 100%;
    width: 100%;
    background-color: #fbd691;
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

.logo{
    padding-bottom: 75px;
    padding-top: 30px;
}

.container .hero .logo{
    display: flex;
    align-items: center;
    position: relative;
}

.container .hero .logo h1{
    font-size: 20px;
}

.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
  flex: 2;
  margin-top: 70px;
}

/*
.content:before {
  content: '';
  flex-grow: 1;
  border: solid 2px black;
}
*/

.content .headline {
    font-weight: bold;
    text-transform: uppercase;
    color: #1a1a1a;
    font-size: 24px;
    position: relative;
 
}
  
.content .headline:before {
    content: '';
    position: absolute;
    width: 100px;
    height: 2px;
    background: #de0c19;
    bottom: -15px;
} 

.content .tabs {
  flex: 2;
  width: 50%;
}

.content .tabs .forgot {
  margin-top: 10px;
  display: block;
  color: #757575;
  text-decoration: none;
}

.content .tabs .forgot:hover {
    color: #de0c19;
}

.tabs form{
    width: 100%;
    transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}

.tabs form .field{
    height: 50px;
    width: 100%;
    margin-top: 20px;
}

.tabs form .field input{
    height: 100%;
    width: 100%;
    outline: none;
    padding-left: 15px;
    border-radius: 15px;
    border: 1px solid lightgrey;
    border-bottom-width: 2px;
    font-size: 13px;
    transition: all 0.3s ease;
}

.tabs form .field input:focus{
    border-color: #fbd691;
}

.tabs form .field input::placeholder{
    color: #999;
    transition: all 0.3s ease;
}

.tabs form .link{
    margin-top: 5px;
}

i{
    margin-left: -30px;
    cursor: pointer;
    opacity: 0.4;
}

form .btn{
    height: 500px;
    width: 100%;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
}

form .btn .btn-layer{
    height: 100%;
    width: 300%;
    position: absolute;
    left: -100%;
    background: black;
    border-radius: 15px;
    transition: all 0.4s ease;;
}

form .btn:hover .btn-layer{
    left: 0;
}

form .btn input[type="submit"]{
    height: 100%;
    width: 100%;
    z-index: 1;
    position: relative;
    background: none;
    border: none;
    color: #fff;
    padding-left: 0;
    border-radius: 15px;
    font-size: 20px;
    font-weight: 500;
    cursor: pointer;
}

.footer_line {
    margin-top: 20px;
    display: flex;
    align-content: center;
    justify-content: center;
}

.footer_text {
    font-weight: 400;
    font-size: 14px;
    color: #010001;
    text-align: center;
}

.footer_link {
    margin-left: 7px;
    font-weight: 400;
    font-size: 14px;
    color: #757575;
    letter-spacing: 0;
    text-align: center;
    cursor: pointer;
}

.content .tabs .footer_link:hover {
    color: #de0c19;
}


.tabs .field .input-half {
	width: 50%;
	float: left;
}

.clipart{
    position: absolute;
    bottom: 0;
    height: auto;
    width: 50%;
}

@media screen and (max-width: 1080px){
    .content .tabs {
        width: 50%;
    }

    .hero{
        flex: 0;
        padding: 0;
        display:none;
    }

    .content .headline {
        font-size: 45px;
    }
    .content .headline:before {
        position: absolute;
        width: 100%;
        height: 2px;
        background: #de0c19;
        bottom: -15px;
    } 

    .content .tabs {
        width: 80%;
    }

    .tabs form .field{
        height: 55px;
        width: 100%;
        margin-top: 20px;
    }  
    .content .tabs .forgot {
        font-size: 17px;
    }
    
    .footer_text {
        font-size: 17px;
    }
    .footer_link {
       font-size: 17px;
    }
}  
</style>


