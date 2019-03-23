<?php
    
?>

<html>
<head >
        <meta charset="UTF-8">

        <link href="assets/css/homeSheet.css" rel="stylesheet" type="text/css" />
        <title>IZTECH itiraf</title> 
</head>
<body id="top" >
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

    <div  class="main">

       
        <?php
             $link = new mysqli('localhost', 'root', '', 'IZTECHConfess');
             if (!$link) {
                 die("Failed connecting to data: ");
             }
             $tableHandler = "SELECT * FROM confessions ORDER BY confessionId DESC";
             $result = $link->query($tableHandler);
             $username = "Anonymous";
             $image_source = 'assets/images/anonim.png';
             while($row = $result->fetch_assoc()) {
                 if($row['anonymity'] == 0) {
                     $username = $row['author'];
                     $image_query = "SELECT profilePicture FROM users WHERE username"."=".'$username';
                     $image_source = $link->query($image_query);
                 }
                 echo "<center> <b>".$row['title']."</b><i style=float:right>".$row['topic']."</i>"."<br/> <br/>";
                 echo $row['content']."<br/>";
                 echo "<a class=hiddenText>".$username.
                 "</a><span class=hiddenImage><img src=".$image_source." width=50px>            </span>
                 ";
                 echo "<br/><br/><br/><hr/>";
             }


        ?>
        
        <p  style="position:sticky;text-align: right"><a  href="#top">To Top</a></p>

    </div>

</body>


<address style=" width: 100%; bottom: 40px; text-align:center;"><a href="index.html">IZTECH Confession</a> &copy; 2018 All rights strictly reserved </address>
</html>