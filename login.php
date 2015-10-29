<?php 
      
    
    require("logindbinfo.php"); 
     
    //use to return the username if login fails
    $submitted_username = ''; 
     
    // check to see if the form was filled in
    if(!empty($_POST)) 
    { 
        // This query retreives the user's information from the database using 
        // their username.
        //to work this MySQL database needs to be installed locally or on your server (phpmyadmin.com) 
        $query = "SELECT id,username,password,salt,email FROM users WHERE username = :username "; 
         
        // The query parameter value assigned after retrieving from the form
        $query_params = array( ':username' => $_POST['username'] ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // un-comment $ex->getMessage() to troubleshoot - otherwise keep messages about your code away from hackers
            die("Failed to run query: " /*. $ex->getMessage() */); 
        } 
         
        // variable for keeping track of whether a user is logged in - initialized to false
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($row) 
        { 
            // this hashes the submitted password and compares it to the hashed password in the database. 
            // salt adds a random character to complicate things and the for loop adds some more steps for a brute force hack FWIW
            //google salt hash and the fourth autocomplete line is "salt hash cracker", thus semi-secure-login *smile* 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
              
            } 
        } 
         
        
        if($login_ok) 
        { 
            //remove the salt and password from your session array so they aren't hanging around waiting to be grabbed 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row;

           /*Un-comment this echo to see if the username was returned from the database which would indicate 
           a session has been initiated and (at least) the username is in the session array.
           The username is used to check for an existing session.
           It will output "Hi yourusername" on the login page and stop the program */
           // die ("Hi " . htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8')); 

            /*Redirect the user to the private members-only page.
            This is the point where the program will fail if the php session info is not properly configured on the server;e.g., godaddy
              */
            header("Location: private.php"); 
            die("Redirecting to: private.php"); 
        } 
        else 
        { 
            // Tell the user they failed 
            print("Login Failed."); 
             
            // Show them their username again in a safe manner. For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 

<h1>Login</h1> 
<form action="login.php" method="post"> 
    Username:<br /> 
    <input type="text" name="username" value="<?php echo $submitted_username; ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Login" /> 
</form> 
<a href="register.php">Register</a> <!--adds a register option not included here (look on the devshed link in readme)-->
