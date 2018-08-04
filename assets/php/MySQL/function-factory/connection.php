<?php

    //estabish database connection
    function getConnection(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname= "suppressionsystem";

        // Create Connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            databaseConnError();
        }
        
        return $conn;
    }
?>