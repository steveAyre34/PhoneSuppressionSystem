<?php
    require("function-factory/connection.php");
    require("function-factory/normal-functions.php");
    require("function-factory/error-functions.php");

    //Add Phone to the database
    function addPhone($data){
        $conn = getConnection();
        date_default_timezone_set("America/New_York");

        //Check for Pre MySQL errors

        $id = "PHO-" . uniqid(rand(), true);
        $name = $data["name"];
        $phone = ($data["type"] == "sms" || $data["type"] == "both" ? "" . 1 . $data["phone"] :  "" . strrev($data["phone"]) . 1);
        $type = $data["type"];

        (!duplicateEntry($conn, $phone, "phone", "phone") ? $phone = $phone : duplicateError($phone, "phone"));

        $columns = implode(",", array("id", 
                    "name", 
                    "phone", 
                    "type")
                );
        
        $sql = "INSERT INTO phone ({$columns}) VALUES (
            '{$id}',
            '{$name}',
            '{$phone}',
            '{$type}')";

        mysqli_query($conn, $sql) or runtimeError();
        mysqli_close($conn) or closeConnError();

        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => array(
                "id" => $id
            )
        );
    }

    //delete phone
    function deletePhone($data){
        $conn = getConnection();

        //Check pre MySql errors
        (duplicateEntry($conn, $data["id"], "id", "phone") ? $data["id"] = $data["id"] : nonExistError($data["id"], "id", "phone"));

        $sql = "DELETE FROM phone WHERE id = '{$data["id"]}'";

        $result = mysqli_query($conn, $sql) or runtimeError();
        mysqli_close($conn) or closeConnError();

        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => array(
                "id" => $data["id"]
            )
        );
    }

    //get phone
    function getPhone($data){
        $conn = getConnection();

        //Check pre MySql errors
        (duplicateEntry($conn, $data["id"], "id", "phone") ? $data["id"] = $data["id"] : nonExistError($data["id"], "id", "phone"));

        $sql = "SELECT * FROM phone WHERE id = '{$data["id"]}'";

        $result = mysqli_query($conn, $sql) or runtimeError();

        $phone = $result->fetch_assoc();
        mysqli_close($conn) or closeConnError();

        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => array(
                "id" => $phone["id"],
                "name" => $phone["name"],
                "phone" => $phone["phone"],
                "type" => $phone["type"]
            )
        );
    }

    //edit phone
    function editPhone($data){
        $conn = getConnection();

        //Check pre MySql errors
        (duplicateEntry($conn, $data["id"], "id", "phone") ? $data["id"] = $data["id"] : nonExistError($data["id"], "id", "phone"));

        $name = $data["name"];
        $id = $data["id"];

        $sql = "UPDATE phone SET `name` = '{$name}' WHERE id = '{$id}'";

        $result = mysqli_query($conn, $sql) or runtimeError();
        mysqli_close($conn) or closeConnError();

        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => array(
                "id" => $id,
                "name" => $name
            )
        );
    }

    //Get multiple phone information
    function getPhones($data){
        $conn = getConnection();

        //prepare search criteria
        $search_criteria = "";
        for($i = 0; $i < count($data["criteria"]); $i++){
            $search_params = "";
            switch($data["criteria"][$i]["rule"]){
                case "exact":
                    $search_params = "{$data["criteria"][$i]["column"]} = '{$data["criteria"][$i]["value"]}'";
                    break;
                case "contains":
                    $search_params = "{$data["criteria"][$i]["column"]} LIKE '%{$data["criteria"][$i]["value"]}%'";
                    break;
                case "greater":
                    $search_params = "{$data["criteria"][$i]["column"]} > '{$data["criteria"][$i]["value"]}'";
                    break;
                case "less":
                    $search_params = "{$data["criteria"][$i]["column"]} < '{$data["criteria"][$i]["value"]}'";
                    break;
            }
            if($i == 0){
                $search_criteria .= "WHERE {$search_params}";
            }
            else{
                switch($data["strict"]){
                    case 1:
                        $search_criteria .= " OR {$search_params}";
                        break;
                    case 2:
                        $search_criteria .= " AND {$search_params}";
                        break;
                }
            }
        }

        //Do SQL statement
        $limit = $data["limit"];
        $page = $data["page"];
        $column = $data["column"];
        $sort = $data["sort"];
        $sql = "SELECT
                    x.count as this_count,
                    id,
                    `name`,
                    phone,
                    `type`
                FROM phone,
                (SELECT count(*) as count FROM phone {$search_criteria}) as x
                {$search_criteria} ORDER BY {$column} {$sort} LIMIT {$data["limit"]} OFFSET " . (($page * $limit) - $limit);
        $result = mysqli_query($conn, $sql) or runtimeError();
        
        $content = array();
        $data = array();
        while($row = $result->fetch_assoc()){
            $content["count"] = $row["this_count"];
            array_push($data, array(
                "id" => $row["id"],
                "name" => $row["name"],
                "phone" => $row["phone"],
                "type" => $row["type"]
            ));
        }
        $content["results"] = $data;
        
        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => $content
        );

    }

    //PUBLIC API'S

    /* return a list of numbers by limit and page */
    function getPhonesPublic($data){

        $conn = getConnection();

        $page = $data["page"];
        $limit = $data["limit"];

        $sql = "SELECT * FROM phone LIMIT {$data["limit"]} OFFSET " . (($page * $limit) - $limit);

        $result = mysqli_query($conn, $sql);

        $content = array();
        $data = array();
        while($row = $result->fetch_assoc()){
            array_push($data, array(
                "id" => $row["id"],
                "name" => $row["name"],
                "phone" => $row["phone"],
                "type" => $row["type"]
            ));
        }
        $content["results"] = $data;

        return array(
            "success" => TRUE,
            "code" => 0,
            "message" => "",
            "content" => $content
        );
    }
?>