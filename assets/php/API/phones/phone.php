<?php
    require('../function-factory/error-functions.php');
    require('../function-factory/normal-functions.php');
    require('../../MySQL/phone.php');

    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            //Check any missing data headers
            $id = $_GET["id"] or dataHeaderError("id");

            //Normal error checks
            (!isBlank($id) ? $id = $_GET["id"] : valueError("id"));

           //Proceed with SQL
            echo json_encode(getPhone(array(
                "id" => $id,
            )));
            break;
        case "POST":
            parse_str(file_get_contents('php://input'), $_POST);

            //Check any missing data headers
            $name = (isset($_POST["name"]) ? $_POST["name"] : "");
            $phone = (isset($_POST["phone"]) ? $_POST["phone"] : "");
            $type = (isset($_POST["type"]) ? $_POST["type"] : "");

            //check errors
            (!isBlank($name) ? $name = $_POST["name"] : valueError("name"));
            (!isBlank($phone) ? $phone = $_POST["phone"] : valueError("phone"));
            (!isBlank($type) ? $type = $_POST["type"] : valueError("type"));
            (preg_match('^\d{7}$^', $phone) || preg_match('^\d{7}$^', $phone) ? $phone = $_POST["phone"] : valueError("phone"));
            (validInputGroup($type, array("sms", "voice mail", "both")) ? $type = $_POST["type"] : valueError("type"));

            //Proceed with SQL
            echo json_encode(addPhone(array(
                "name" => $name,
                "phone" => $phone,
                "type" => $type
            )));

            break;
        case "PATCH":
            parse_str(file_get_contents('php://input'), $_PATCH);

            //Check any missing data headers
            $id = (isset($_PATCH["id"]) ? $_PATCH["id"]: "");
            $name = (isset($_PATCH["name"]) ? $_PATCH["name"] : "");
            //Normal error checks
            (!isBlank($id) ? $id = $_PATCH["id"] : valueError("id"));
            (!isBlank($name) ? $name = $_PATCH["name"] : valueError("name"));

           //Proceed with SQL
            echo json_encode(editPhone(array(
                "id" => $id,
                "name" => $name
            )));
            break;
        case "DELETE":
            parse_str(file_get_contents('php://input'), $_DELETE);

            //Check any missing data headers
            $id = $_DELETE["id"] or dataHeaderError("id");

            //Normal error checks
            (!isBlank($id) ? $id = $_DELETE["id"] : valueError("id"));

           //Proceed with SQL
            echo json_encode(deletePhone(array(
                "id" => $id,
            )));
            break;
        default: 
            requestMethodError();
            break;
    }
?>