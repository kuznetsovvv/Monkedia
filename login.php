<?php
require_once(getcwd()."/header.php");
?>
<script src="login.js"></script>
<form id="loginForm" action="./checkLogin.php" method="post" enctype="multipart/form-data"> <!-- we specify the use of encryption here, this is important, as this is a login form -->
    <label>Username: </label><br /><input type="text" id="user" name="user" /><br />
    <label>Password:</label><br /><input type="password" id="pass" name="pass" /><br />
    <a onclick="javascript:loginValidate();">Login &raquo;</a><br />
</form>
<div id="loginErrors"></div>
<script>loginErrors();</script> <!-- put this function call below the error area as an easy way to assure it has a target to write to -->
<?php
require_once(getcwd()."/footer.php");
ob_flush(); die(); //only output the buffer's contents once the page is done processing. We make sure the process is done right after.
?>