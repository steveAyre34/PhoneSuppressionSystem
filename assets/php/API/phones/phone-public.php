<?php
    require('../function-factory/error-functions.php');
    require('../function-factory/normal-functions.php');
    require('../../MySQL/phone.php');

    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            //Check any missing data headers
            $page = (isset($_GET["page"]) ? $_GET["page"] : "");
            $limit = (isset($_GET["limit"]) ? $_GET["limit"] : "");

            //Normal error checks
            (!isBlank($page) ? $page = $_GET["page"] : valueError("page"));
            (validNumberInput($page) ? $page = $_GET["page"] : valueError("page"));
            (!isBlank($limit) ? $limit = $_GET["limit"] : valueError("limit"));
            (validNumberInput($limit) ? $limit = $_GET["limit"] : valueError("limit"));

           //Proceed with SQL
            echo json_encode(getPhonesPublic(array(
                "page" => $page,
                "limit" => $limit
            )));
            break;
        default: 
            requestMethodError();
            break;
    }
?>