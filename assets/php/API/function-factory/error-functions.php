<?php
/*
  - -1 -> Request Body Header Errors
  - -2 -> Syntax Errors
 */

    //When wrong request method is used
    //Code = -1
    function requestMethodError(){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -1,
            "message" => "invalid request method",
            "content" => array()
        ));
        die();
    }

    //Responds when a value's syntax is deemed incorrect
    //Code = -2
    function valueError($header){
        echo json_encode(array(
            "success" => FALSE,
            "code" => -2,
            "message" => "'{$header}' has syntax error",
            "content" => array()
        ));
        die();
    }

?>