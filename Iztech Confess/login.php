<?php if (isset($_POST['Submit'])) {
  
     $table = "users";
     $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
    if (!$link) {
        die("Failed connecting to data: ");
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM $table WHERE username='$username' AND password='$password'";

    $result = $link->query($query);
    if ($result->num_rows > 0) {
        while($line = $result->fetch_assoc()) {
            echo ("First Name: " . $line["username"]. $line["password"] ."<br>");
        }
        
    }
    if ($result->num_rows == 1) {
        setcookie('user', $username, time() + 86400);
        header("Location:index.php");
    }
    else { ?>
        <html>
    <head>
        <title>IZTECH itiraf</title>
        <link href="assets/css/homeSheet.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
    <div style="float: right" >
                <ul style="    list-style: none; display:flex">
                <li> <?php 
                if (isset($_COOKIE['user'])) {
                    echo $_COOKIE['user']."&nbsp;&nbsp;";                ?> </li>
                 <li><a href='logout.php'>Logout</a></li>
                 </ul>
                
                 <img src="<?php
                    $user_url;
                    if (isset($_COOKIE['user'])) {
                        $table = "users";
                        $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
                       if (!$link) {
                           die("Failed connecting to data: ");
                       }
                       $user_name = $_COOKIE['user'];
                       $query = "SELECT profilePicture FROM users where username"."="."'".$user_name."'";
                       $result = $link->query($query);
                       if ($result) {
                           if ($result->num_rows == 1) {
                            while($row = $result->fetch_assoc()){    
                                $user_url = $row['profilePicture'];                
                            }
                
                           }
                       }
                
                    }
                 
                 echo $user_url; ?>" height="80" width="80" alt="No image"/>
                <?php } 
                else { ?>
            <a href='login.php'>Login</a>
       <?php }?>
            
    </div>
    <div > 
        <a href="index.php"><img  src="assets/images/logo.png"/></a>
        <a href="about.php"><img align="right" src="assets/images/about.png"/></a>
        <a href="confession-form.php"><img src="assets/images/confess.png"></a>
        <a href="signup.php"><img align="right" src="assets/images/signup.png"/></a>
        <a href="login.php"><img align="right" src="assets/images/signin.png"/></a>

        </div>

        <div>
            <h1 style="text-align: center; font-size: 50px">Sign In Form</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method='POST'>
                <?php if($result->num_rows != 1) {
                    echo "<p> <font color='red' size=5> The username or password seems to be incorrect.</font></p>";
                } ?>
                <p>Username:
                <input  name="username", placeholder="Username" type="text" style="height:40px; width: 300px"/> </p>
                <p>Password:
                <input  name="password", placeholder="Password" type="password" style="height:40px; width: 300px"/> </p>
                <input type="submit" name="Submit" value="Sign In" style=" height:30px; width:100px" />
                <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />

                <p><a href="reset-password.html">Forgot your password?</a></p>

            </form>
        </div>
    </body>

    </html>
   <?php }

}else {?>
    <html>
    <head>
        <title>IZTECH itiraf</title>
        <link href="assets/css/homeSheet.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
    <div style="float: right" >
                <ul style="    list-style: none; display:flex">
                <li> <?php 
                if (isset($_COOKIE['user'])) {
                    echo $_COOKIE['user']."&nbsp;&nbsp;";                ?> </li>
                 <li><a href='logout.php'>Logout</a></li>
                 </ul>
                
                 <img src="<?php
                    $user_url;
                    if (isset($_COOKIE['user'])) {
                        $table = "users";
                        $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
                       if (!$link) {
                           die("Failed connecting to data: ");
                       }
                       $user_name = $_COOKIE['user'];
                       $query = "SELECT profilePicture FROM users where username"."="."'".$user_name."'";
                       $result = $link->query($query);
                       if ($result) {
                           if ($result->num_rows == 1) {
                            while($row = $result->fetch_assoc()){    
                                $user_url = $row['profilePicture'];                
                            }
                
                           }
                       }
                
                    }
                 
                 echo $user_url; ?>" height="80" width="80" alt="No image"/>
                <?php } 
                else { ?>
            <a href='login.php'>Login</a>
       <?php }?>
            
    </div>
        <div > 
        <a href="index.php"><img  src="assets/images/logo.png"/></a>
        <a href="about.php"><img align="right" src="assets/images/about.png"/></a>
        <a href="confession-form.php"><img src="assets/images/confess.png"></a>
        <a href="signup.php"><img align="right" src="assets/images/signup.png"/></a>
        <a href="login.php"><img align="right" src="assets/images/signin.png"/></a>

        </div>

        <div>
            <h1 style="text-align: center; font-size: 50px">Sign In Form</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method='POST'>
                
                <p>Username:
                <input  name="username", placeholder="Username" type="text" style="height:40px; width: 300px"/> </p>
                <p>Password:
                <input  name="password", placeholder="Password" type="password" style="height:40px; width: 300px"/> </p>
                <input type="submit" name="Submit" value="Sign In" style=" height:30px; width:100px" />
                <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />

                <p><a href="checkUser.php">Forgot your password?</a></p>

            </form>
        </div>
    </body>
    <address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

    </html>
<?php
}
?>
