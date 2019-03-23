<?php 

if (isset($_POST['reset'])) {
    
  //TODO check it the database exists yet or not. act accordingly.   make it a function and use it when needed.
//TODO check if user in database . if yes don't add and give a warning message. If not add him and sign him up, and redirect to index page.
    $dbName = "IZTECHConfess";
    $server = "localhost";
    $username = "root";
    $dbPassword = "";
    $table = "users";
    $userId;
    $input_username = $_POST['username'];
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];
    $input_confirmPassword = $_POST['confirmPassword'];
    $profilePicture = $_POST['profilePicture'];
    if (!isset($profilePicture)) {
        $profilePicture = ' ';
    }
    
    $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
    if (!$link) {
        die("Failed connecting to data: ");
    }
   
    $flag  = false;
    // check if the table already exists or not.

    //TODO Login after registering.
    $exist = $link->query("SHOW TABLES LIKE '".$table."%'");
    
    if($exist->num_rows > 0) {
        $inputValidatior = "SELECT username, email, userId FROM users";
        $result = $link->query($inputValidatior);
        $flag = true;
            while($row = $result->fetch_assoc()) {

                if( $row['username'] == $_POST['username'] && $row['email']== $_POST['email']) {
                    $userId=$row['userId'];                    
                    $flag = true;
                    setcookie('userId', $userId,time() + 86400);
                    break;
                }
            }
        
        
        if ($flag) {
                header("Location: reset-password.php");
        }
    }

}
else{     $password_confirmed= false;
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
            <h1 style="text-align: center; font-size: 50px">Confirm Information</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method='POST'>
                
                <p>Username:
                <input  name="username", placeholder="Name" type="text" style="height:40px; width: 300px"/> </p>
                <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input  name="email", placeholder="Email" type="text" style="height:40px; width: 300px"/> </p>
                <input type="submit" name="reset" value="Reset" style=" height:30px; width:100px" />
                <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />



            </form>
        </div>
    </body>
    <address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

    </html>

<?php }?>