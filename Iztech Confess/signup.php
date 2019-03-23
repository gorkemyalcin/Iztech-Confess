<?php 

if (isset($_POST['submit']) && ($_POST['password'] == $_POST['confirmPassword'])) {
    
  //TODO check it the database exists yet or not. act accordingly.   make it a function and use it when needed.
//TODO check if user in database . if yes don't add and give a warning message. If not add him and sign him up, and redirect to index page.
    $dbName = "IZTECHConfess";
    $server = "localhost";
    $user = "root";
    $dbPassword = "";
    $table = "users";
    $input_username = $_POST['username'];
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];
    $input_confirmPassword = $_POST['confirmPassword'];

    if (isset($_FILES["profilePicture"]["name"])) {
        $profilePicture = 'assets/images/userProfiles/';
        $image_name = $_FILES['profilePicture']['name'];
        $file_size = $_FILES['profilePicture']['size'];
        if(empty($_FILES['profilePicture']['name'])){
            $profilePicture = 'assets/images/anonim.png';
        }
        else{
            $profilePicture = $profilePicture . $image_name;
            move_uploaded_file($_FILES['profilePicture']['tmp_name'], $profilePicture);
        }
    }
    
    $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
    if (!$link) {
        die("Failed connecting to data: ");
    }
   /* $sql = "CREATE DATABASE $dbName";
    $creation = $link->query($sql);
    if (!$creation->error) {
        echo("Error while creating database:". $creation->error);
    } */
    $flag  = true;
    // check if the table already exists or not.

    $exist = $link->query("SHOW TABLES LIKE '".$table."%'");
    if (!$exist ) {

        $table = "CREATE TABLE users (username varchar(50) NOT NULL, email varchar(100) NOT NULL, password varchar(50) NOT NULL, userId int(5)  AUTO_INCREMENT PRIMARY KEY, profilePicture varchar(200))";
        $link->query($table);
        $saver = "INSERT INTO users VALUES ('$input_username', '$input_email', '$input_password', null, $profilePicture)";
            $saved = $link->query($saver);
            if($saved) {
                setcookie('user', $input_username, time() + 86400);
                header("Location: index.php");
            }

    }else if($exist->num_rows > 0) {

        $inputValidatior = "SELECT username, email FROM users";
        $result = $link->query($inputValidatior);
        $flag = true;
            while($row = $result->fetch_assoc()) {

                if( $row['username'] == $_POST['username'] || $row['email']== $_POST['email']) {
                    $flag = false;
                    break;
                    //TODO already exists

                }
            }
        
        
        if ($flag) {
            
            $saver = "INSERT INTO users VALUES ('$input_username', '$input_email', '$input_password','', '$profilePicture')";
            $saved = $link->query($saver);
            if($saved) {
                setcookie('user', $input_username, time() + 86400);
                header("Location: index.php");
            }
        }
        else{?>
            <html>
<head>
        <link href="assets/css/homeSheet.css" rel="stylesheet" type="text/css" />

    <title>IZTECH itiraf</title>
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
    <div style="top: 5px"> 
    <a href="index.php"><img  src="assets/images/logo.png"/></a>
        <a href="about.php"><img align="right" src="assets/images/about.png"/></a>
        <a href="confession-form.php"><img src="assets/images/confess.png"></a>
        <a href="signup.php"><img align="right" src="assets/images/signup.png"/></a>
        <a href="login.php"><img align="right" src="assets/images/signin.png"/></a>
    
    </div>

    <div>
        <h1 style="text-align: center; font-size: 50px">Sign Up Form</h1>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method="POST">
            <p> Username or email already in use, please try again.</p>
            <p>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <? if (!$flag) { echo "username already in use!";
                }?>
            <input  name="username", placeholder="Username" type="text" style="height:40px; width: 300px" required/> </p>
            <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input  name="email", placeholder="Email" type="text" style="height:40px; width: 300px" required/> </p>
            <p>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input  name="password", placeholder="Password" type="password" style="height:40px; width: 300px" required/> </p>
            <p>Confirm Password:
            <input  name="confirmPassword", placeholder="Confirm Password" type="password" style="height:40px; width: 300px" required/> </p>
            <? //if ($password_confirmed == false) {
                echo "Password not matched!";
            //} 
            
            ?>

            <p style="color: red; font-size:20"> Your photo should have a size less than 1 MB</p>
            <input name="profilePicture" type="file" accept="image/*" >
                    <input type="submit" name="submit" value="Sign Up" style=" height:30px; width:100px" />
            <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />

            <p><a href="login.html">I already have an account and so ready to confess!</a></p>
            
        </form>
    </div>
</body>
<address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

</html>
       <?php }
    }
    else {
        
        $saver = "INSERT INTO users VALUES ('$input_username', '$input_email', '$input_password','', '$profilePicture')";
        $saved = $link->query($saver);
        if($saved) {
            setcookie('user', $input_username, time() + 86400);
            header("Location: index.php");
        }      
    }

}
else{     $password_confirmed= false;
    ?>
    <html>
<head>
        <link href="assets/css/homeSheet.css" rel="stylesheet" type="text/css" />

    <title>IZTECH itiraf</title>
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
    <div style="top: 5px"> 
    <a href="index.php"><img  src="assets/images/logo.png"/></a>
        <a href="about.php"><img align="right" src="assets/images/about.png"/></a>
        <a href="confession-form.php"><img src="assets/images/confess.png"></a>
        <a href="signup.php"><img align="right" src="assets/images/signup.png"/></a>
        <a href="login.php"><img align="right" src="assets/images/signin.png"/></a>
    
    </div>

    <div>
        <h1 style="text-align: center; font-size: 50px">Sign Up Form</h1>
        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="font-size: 30px" align="center" method="POST">
            <p>Username: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <? if (!$flag) { echo "username already in use!";
                }?>
            <input  name="username", placeholder="Username" type="text" style="height:40px; width: 300px" required/> </p>
            <p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input  name="email", placeholder="Email" type="text" style="height:40px; width: 300px" required/> </p>
            <p>Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input  name="password", placeholder="Password" type="password" style="height:40px; width: 300px" required/> </p>
            <p>Confirm Password:
            <input  name="confirmPassword", placeholder="Confirm Password" type="password" style="height:40px; width: 300px" required/> </p>
            <? //if ($password_confirmed == false) {
                echo "Password not matched!";
            //} 
            if (!$flag) {
                echo "Username or email already in use";
            }
            ?>

            <p style="color: red; font-size:20"> Your photo should have a size less than 1 MB</p>
            <input name="profilePicture" type="file" accept="image/*" >
                    <input type="submit" name="submit" value="Sign Up" style=" height:30px; width:100px" />
            <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />

            <p><a href="login.html">I already have an account and so ready to confess!</a></p>
            
        </form>
    </div>
</body>
<address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

</html>
<?php } ?>