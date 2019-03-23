<?php

//TODO Everything about images.
if (isset($_POST['submit'])) {
    $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
    if (!$link) {
        die("Failed connecting to data: ");
    }
    $content = $_POST['Confession'];
    $title = $_POST['title'];
    $topic = $_POST['topic'];
    $photo = '';
    $author = $_COOKIE['user'];
    if (!empty($_POST['anon'])){
        if ($_POST['anon'] == "anon"){
            $anonymity = 1;
        }
        else {
            $anonymity = 0;
        }
    }
    else {
        $anonymity = 1;
    }
    $query = "INSERT INTO confessions VALUES ('$content', '$author', '$topic',  '$title', null, '$anonymity')";
    if ($link->query($query)) {
        header("Location: index.php");
    }else {
        header("Location: signup.php");

    }


}else {?>
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
                    echo $_COOKIE['user']."&nbsp;&nbsp;";
                ?> </li>
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
        <h1 style="text-align: center; font-size: 50px">Confession Form</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="font-size: 30px" align="center">
            <p>Topic: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <select name="topic"> 
                <option selected value="Default"/> Default  
                <option value="Love"/> Love
                <option value="Anger"/> Anger
                <option value="Complain"/> Complain
                <option value="Announcement"/>Announcement
                <option value="Question"/>Question 
            </select> </p>
            <p> <textarea cols="40" type="text" name="title" placeholder="Title"  ></textarea></p>
            <p>
                    <textarea cols="40" rows="10" name="Confession", placeholder="Confession" type="text" style="height:400px; width: 800px"></textarea> </p>
            <br/><input type="radio" name="anon" value="anon" checked/> Anonymous 
            <input type="radio" name="anon" value="nonanon"/> Show My Name<br/>
            <input type="submit" name="submit" value="Confess" style=" height:30px; width:100px" />
            <input type="reset" name="clear" value="Clear" style=" height:30px; width:100px" />
            

            
        </form>
    </div>
</body>
<address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>

</html>
<?php }

?>