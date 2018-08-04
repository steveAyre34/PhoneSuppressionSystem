<?php
    /*
    -500 -> connection error
    -501 -> pre mysql errors
    -502 -> mysql runtime errors
    -503 -> closing connection errors
     */
    // database connection error when establishing connection
    function databaseConnError(){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -500,
            "message" => "database connection error",
            "content" => array()
        ));
        die();
    }

    //Responds when a duplicate value is found preventing from completion of request
    function duplicateError($value, $header){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -501,
            "message" => "'{$value}' is a duplicate in '{$header}'",
            "content" => array()
        ));
        die();
    }

    //Responds when a needed value is not found in a table
    function nonExistError($value, $header, $table){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -501,
            "message" => "'{$value}' not found in column '{$header}' of '{$table}'",
            "content" => array()
        ));
        die();
    }

    //Responds when a runtime mysql error occurs
    function runtimeError(){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -502,
            "message" => "Error occurred running MySQL query",
            "content" => array()
        ));
        die();
    }

    //closing mysql error occurs
    function closeConnError(){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -503,
            "message" => "Connection was not closed properly",
            "content" => array()
        ));
        die();
    }
?>