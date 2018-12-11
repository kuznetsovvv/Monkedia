<?php
// I felt it was best to isolate this security-critical function from the rest of the code.
// This will make life easier if issues come up and this needs to be updated or debugged later.
// For example, if the cryptographic functions became deprecated, we wouldn't want to mess with our entire codebase to update them.
require_once(getcwd()."/header.php");
?>
    <p>Logging you in, please wait...</p>                   <!-- User shouldn't see this, but sometimes the browser takes a moment to redirect, so we leave a friendly note -->
        
<?php
require_once(getcwd()."/footer.php");

function checkLogin($username, $password){
    
    
    $servername = "localhost";
    $sqlusername = "demouser";
    $sqlpassword = "Passw0rd";
    $dbname = "monkedia";

    // Create connection
    $conn = new mysqli($servername, $sqlusername, $sqlpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
   
    $queryStatement = "select Username, hash from users WHERE Username ='$username'";
    $result = $conn->query($queryStatement);
    $validUser = $result->fetch_assoc();
    
    $loginAssessment = "An unexpected error has occured during login. Please contact me at <a href='vkuznetsov351@gmail.com'>vkuznetsov351@gmail.com'</a>, and I will look into it for you."; //default is an error message
    
    //I've elected to give the client detailed information on which part of logging in they got wrong.
    if(password_verify($password, $validUser["hash"]) && ($validUser["Username"] == $username)){
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        setcookie("extrakey", password_hash($_SERVER['REMOTE_ADDR'].$username, PASSWORD_DEFAULT), time() + 3600, "/"); // We'll add this extra Key as an extra layer on top of the session variable.);
        $loginAssessment = 0;
    }elseif($validUser["Username"] == $username){
        logout(false);
        $loginAssessment = "password";
    }else{
        logout(false);
        $loginAssessment = "username";
    }
    if($loginAssessment === 0){
        header("Location: ./display.php");
    }else{
        header("Location: ./login.php?loginErrors=$loginAssessment");
    }
}
function logout($redirect = true){
    $_SESSION['loggedin'] = false;
    $_SESSION['username'] = "";
    setcookie("extrakey", 0, time() - 999999, "/");
    if($redirect == true){
        header("Location: ./login.php?loginErrors=loggedout");
    }
}

if(isset($_GET["action"])){
    if($_GET["action"] == "out"){
        logout();
    }else{
        checkLogin($_POST["user"], $_POST["pass"]); 
    }
}else{
    checkLogin($_POST["user"], $_POST["pass"]); 
}
    

ob_flush(); die(); //only output the buffer's contents once the page is done processing. We make sure the process is done right after.This is crucial since the redirect headers MUST be sent before the ob_flush is called.
?>