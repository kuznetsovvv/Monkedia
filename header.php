<?php
// It all begins here, this serves as the very beginning of the output material.
// Quite a few things are going on here. For starters, we initiate a few variables, start a buffer and session,
// import scripts and styles, and begin outputting html that we will reuse across the whole project

    ob_start(); // best practices dictate buffering outputs, especially headers, as they cannot be sent after the rest of the page
    session_start();         

    $username = $_SESSION["username"] ;
    $loggedIn = $_SESSION['loggedin'] ;

    error_reporting(E_ALL);          //TODO: remove these statements used for debug
    ini_set("display_errors", 1);    //*/

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){                     //Detect whether SSL is in use, and normally we'd redirect them to the SSL version. 
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    /*
    header('HTTP/1.1 301 Moved Permanently');                                 //Since I don't know if my tester has an SSL cert, we'll just warn the user instead
    header('Location: ' . $redirect);
    exit();
    */
    if(!isset($_COOKIE["SSL_WARNED"]) ){
        $redirectWarnMsg = "A secure application should use encryption.";
        $redirectWarnMsg .= "\\nI've not redirected you, in case there's no SSL cert configured on your test server.";
        $redirectWarnMsg .= "\\n\\nIn this case, you would use the url: \\n$redirect"; // The way PHP treats double quotes makes concatenation unnecessary. 
        echo("<script>alert(\"".$redirectWarnMsg."\" );</script>");          
        setcookie("SSL_WARNED", 1, time() + 3600, "/");                           //An hour should be enough for our purposes
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vladimir Kuznetsov</title>
    <link rel="stylesheet" href="./styles.css"> <!--These imports will be cached on the clientside. As a result, even a large stylesheet is only downloaded once -->
    <script src="./generic.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> <!-- popular CDN means the client might even already have bootstrap & jquery cached in advance -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>
    <header id="theHeader">
        <p id="headerMain">Vladimir Kuznetsov</p>
        <p class="headerSub"><a href="mailto:vkuznetsov351@gmail.com">vkuznetsov351@gmail.com</a></p>
        <p class="headerSub"><a href="tel:+14433648337">+1 (443) 364-8337</a></p> 
        <?php if($loggedIn){?>
        <div id="logoutButton"><a href="checkLogin.php?action=out">Log out</a></div>
        <?php } ?>
    </header>
<body id="thebody">
<div class="container">
    <div class="row">
        <div class="hidden-xs col-sm-1 col-md-1 col-lg-1">&nbsp;</div>       <!-- I just use this column to pad out the content area. It should be hidden on the smallest displays.-->
        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10" id="contentArea"> <!-- end of Footer.php and the beginning of the HTML content area -->