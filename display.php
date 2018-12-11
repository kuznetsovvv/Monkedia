<?php
require_once(getcwd()."/header.php");
if($loggedIn != true){
    header("Location: ./login.php?loginErrors=not%20logged%20in"); //nice rejection
    die("User isn't logged in.");
}else{ 
?>
<script src="display.js"></script>
<div id="testout"></div> <!-- useful for test data, could also throw errors up here -->
<h1>Clients</h1> 
<p>Click a row to edit client</p>
<div id="outputArea"></div>
<a href="#" onclick="javascript:newRow()">Add a new Client</a>
<script>fetchList();</script> <!-- put this function call below the output area as an easy way to assure it has a target to write to -->
<?php
}
require_once(getcwd()."/footer.php");
ob_flush(); die(); //only output the buffer's contents once the page is done processing. We make sure the process is done right after.
?>