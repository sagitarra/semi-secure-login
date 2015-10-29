<?php 

    // First we execute our common code to connection to the database and start the session 
    require("logindbinfo.php"); 
     //we can use this to check if the session was passed between pages. If not passed it will out put "Hi  "
     // die ("Hi " . htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8')); 


    /*By uncommenting this we can check to see if the php configuration will pass your session between the pages
    Compare upload_temp_dir in Core to session.save_path in Session.
    They should be the same (at least in local config).
    */
     //die(phpinfo());//this stops the program and shows all the php info
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 

        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
?> 
Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>, welcome to your note keeper app<br /> 

<form action="notecatcher.php" method="post">
<p><b>Subject:</b> <input type="text" name="subject" /></p>
<p><b>Your comments:</b><br />
<textarea name="comments" rows="15" cols="50"></textarea></p>

<p><input type="submit" value="Save it!"></p>

<form>

<!--<a href="memberlist.php">Memberlist</a><br /> -->
<a href="edit_account.php">Edit Account</a><br /> 
<a href="logout.php">Logout</a> 