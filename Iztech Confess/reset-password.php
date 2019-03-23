<?php 
if (isset($_POST['reset']) && $_POST['password']==$_POST['confirmPassword']) {
    if(isset($_COOKIE['userId'])) {
        $table = "users";
        $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
       if (!$link) {
           die("Failed connecting to data: ");
       }
       $password = $_POST['password'];
       $userId = $_COOKIE['userId'];
       $query = "UPDATE users SET password=$password  WHERE userId=$userId";
       $check = "SELECT password from users WHERE userId=$userId";
       $result = $link->query($query);

       if ($result) {
            header("Location: login.php");
        }
    }
}
else {
?>
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
            <h1 style="text-align: center; font-size: 50px">Reset Password</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method='POST'>
                
                <p>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  name="password", placeholder="Password" type="password" style="height:40px; width: 300px" required/> </p>
                <p>Confirm Password:
                <input  name="confirmPassword", placeholder="Confirm Password" type="password" style="height:40px; width: 300px" required/> </p>
                <input type="submit" name="reset" value="Reset" style=" height:200px; width:80px" />
                <input type="reset" name="clear" value="Clear" style=" height:200px; width:80px" />

                <p><a href="reset-password.html">Forgot your password?</a></p>

            </form>
        </div>
    </body>
    <address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

    </html>
    <?php } ?>