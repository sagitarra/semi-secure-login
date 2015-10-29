<?php 
    
    // These variables define the connection information for your MySQL database 
    $username = "yourusername"; 
    $password = "yourpassword"; 
    $host = "12.34.56.78";//ip address works fine 
    $dbname = "yourdbname"; 

    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); //use utf8 for all characters
     
    try //set a connection to your database
    { 
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        //un-comment the PDOException to troubleshoot but leave it commented to hide info about your code that would be available to hackers
        die("Failed to connect to the database: " /* . $ex->getMessage() */); 
    } 
     
    //sets up the exception handling such as above
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    // sets up query to return an array that includes associated info to use in your code 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // this negates a built in option which was quickly hacked 
    // http://php.net/manual/en/security.magicquotes.php 

    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
     
    // This tells the web browser that it should submit content back to you using UTF-8 
     header('Content-Type: text/html; charset=utf-8'); 
      
    //every session needs this so start
     session_start(); 

    // Note that it is a good practice to NOT end your PHP files with a closing PHP tag. 
    // This prevents trailing newlines on the file from being included in your output, 
    // which can cause problems with redirecting users. 