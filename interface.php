<?php //this file serves as a backend, we'll do our main database work here

session_start(); 
$loggedIn = $_SESSION['loggedin'] ;

if(($loggedIn == true && password_verify($_SERVER['REMOTE_ADDR'].$username, $_COOKIE["extrakey"]))){                 //do some security checks
    header("Location: ./login.php"); 
    die("User isn't logged in.");
}else{
    
    function listEntries($connection){
        $queryStatement = "select * from clients";
        $result = $connection->query($queryStatement);
        $clientlist = [];
        $clientListIndexed = array();
        if ($result->num_rows > 0) {
            // collect data into an array
            while($clients = $result->fetch_assoc()) {
                array_push($clientlist, $clients);
            }
        }
        foreach ($clientlist as $clientdata){
            $clientListIndexed[$clientdata["ID"]] = $clientdata;
        }
            
        return($clientListIndexed);
    }
    function update($connection, $data){
        $queryStatement = "UPDATE clients SET ";
        $id = -1; //will fail if this goes through
        $count = count($data);
        foreach($data as $key => $value){
            $count -= 1;
            if($key == "ID"){
                $id = $value;
            }elseif($key != "fn"){
                $queryStatement .= "$key= '$value'";
                if($count != 0){
                    $queryStatement .= ", ";
                }
            }
        }
        $queryStatement .= " WHERE ID = $id";
        $result = $connection->query($queryStatement);
        return $result;
    }
    function createNew($connection, $data){
        $queryStatement = "INSERT INTO clients (";
        $id = -1; //will fail if this goes through
        $count = count($data);
        foreach($data as $key => $value){
            $count -= 1;
            if($key != "fn"){
                $queryStatement .= "$key";
                if($count != 0){
                    $queryStatement .= ", ";
                }
            }
        }
        $queryStatement .= ") VALUES (";
        $count = count($data);
        foreach($data as $key => $value){
            $count -= 1;
            if($key != "fn"){
                $queryStatement .= "'$value'";
                if($count != 0){
                    $queryStatement .= ", ";
                }
            }
        }
        $queryStatement .= ") ";
        $result = $connection->query($queryStatement);
        return $result;
    }
    
    $servername = "localhost";
    $sqlusername = "demouser";
    $sqlpassword = "Passw0rd";
    $dbname = "monkedia";
    
    $conn = new mysqli($servername, $sqlusername, $sqlpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  

    if($_GET["fn"] == "list"){
        echo json_encode(listEntries($conn));  //output json
    }
    if($_GET["fn"] == "update"){
        $data = $_GET;
        echo update($conn, $data);
    }
    if($_GET["fn"] == "new"){
        $data = $_GET;
        echo createNew($conn, $data);
    }

    $conn->close();
    
}
